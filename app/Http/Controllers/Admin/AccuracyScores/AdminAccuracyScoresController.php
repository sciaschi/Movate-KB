<?php

namespace App\Http\Controllers\Admin\AccuracyScores;

use App\Http\Controllers\Admin\Users\AdminUsersController;
use App\Http\Controllers\Controller;
use App\Models\AccuracyScore\AccuracyScore;
use App\Models\User\User;
use App\Models\UserAccuracyScore\UserAccuracyScore;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AdminAccuracyScoresController extends Controller
{
    /**
     * @return Response
     */
    public function index() {
        $users = User::with(['accuracy_scores' => function($q) {
            $q->latest();
        }])->get();

        $mappedUsers = $users->map(function($e){
            $accuracyScores = $e->accuracy_scores()->first() ?? null;
            return [
                'id'             => $e->id,
                'name'           => $e->name,
                'accuracy_score' => $accuracyScores ? $accuracyScores->accuracy_grade . '%' : 'N/A',
                'last_updated'   => $accuracyScores ? Carbon::parse($accuracyScores->updated_at)->format('m/d/Y') : 'No Audits Yet'
            ];
        });

        return Inertia::render('Admin/AccuracyScores/Index', [
            'users' => $mappedUsers
        ]);
    }

    /**
     * @return Response
     */
    public function historical($id) {
        return Inertia::render('Admin/AccuracyScores/Historical', [
            'user' => User::find($id)->name ?? null
        ]);
    }

    /**
     * @param int|null $id
     * @return Response
     */
    public function grade(int $id = null) {
        return Inertia::render('Admin/AccuracyScores/Grade', [
            'gradingUser' => $id ? User::find($id)->get(['id', 'name']) : null
        ]);
    }


    /**
     * @return JsonResponse
     */
    public function getAllUsers() {

        return response()->json([
            'status' => true,
            'data'   => User::with(['accuracy_scores' => function($q) {
                $q->orderBy('created_at', 'desc');
            }])->get(['id', 'name', 'email'])
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getAllUsersWithRole() {

        return response()->json([
            'status' => true,
            'data'   => User::role('Moderator')->get(['id', 'name'])
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAverageAccuracyByDates(Request $request) {
        $data         = $request->all();
        $dates        = $data['dates'];
        $accuracyData = UserAccuracyScore::whereBetween('created_at', [$dates[0], $dates[count($dates) - 1]])
            ->selectRaw('avg(accuracy_grade) AS avg_val, created_at')
            ->groupByRaw('created_at')
            ->get();

        $mappedData   = $accuracyData->map(function($d) {
            return[
                'created_at' => Carbon::parse($d['created_at'])->format('Y-m-d'),
                'avg_val'    => $d['avg_val'],
            ];
        })->toArray();

        $result = [];

        foreach($mappedData as $val){
            $result[$val['created_at']] = $val['avg_val'];
        }

        foreach($dates as $date) {
            $result[$date] = $result[$date] ?? 0;
        }

        return response()->json([
            'status' => true,
            'data'   => collect($result)->sortKeys()->flatten()->toArray()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createAccuracyScore(Request $request) {
        $data = $request->all();


        $addData = collect(array_filter($data['data']))->map(function($el) use ($data) {
            return [
                'user_id'     => $data['user_id'],
                'admin_id'    => Auth::user()->id,
                'username'    => $el['username'],
                'mod_flagged' => $el['mod_flagged'],
                'is_correct'  => $el['is_correct'],
                'created_at'  => Carbon::Now()
            ];
        })->toArray();

        $correct = 0;

        foreach($data['data'] as $score) {
            if($score['is_correct']) {
                $correct++;
            }
        }

        $accuracyScore = ($correct / count($data['data'])) * 100;

        if($res = AccuracyScore::insert($addData))
        {
            $userAccScore = new UserAccuracyScore([
                'user_id'        => $data['user_id'],
                'accuracy_grade' => $data['accuracy'] ?? $accuracyScore,
                'created_at'     => Carbon::Now()
            ]);

            if($secRes = $userAccScore->save()) {
                return response()->json([
                    "status" => true,
                    "data"   => $secRes
                ]);
            }
            else
            {
                return response()->json([
                    "status" => false,
                    "errors" => $secRes
                ]);
            }
        }
        else
        {
            return response()->json([
                "status"    => false,
                "response"  => $res
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateHistoricalData(Request $request) {
        $rawData = $request->all();
        $data = $rawData['data'];
        $correct = 0;

        foreach ($data as $value) {
            AccuracyScore::find($value['id'])->update($value);
        }

        $userAccScores = AccuracyScore::getHistoricalData($rawData['user_id'], $rawData['date']);

        foreach ($userAccScores['data'] as $value) {
            if($value['is_correct'] === 1) {
                $correct++;
            }
        }

        $accuracyScore = ($correct / count($userAccScores['data'])) * 100;

        $accuracyUpdate = UserAccuracyScore::where('user_id', '=', $rawData['user_id'])->update([
            'accuracy_grade' => $accuracyScore
        ]);

        if($accuracyUpdate) {
            return response()->json([
                'status' => true,
                'data'   => AccuracyScore::getHistoricalData($rawData['user_id'], $rawData['date'])
            ]);
        }

        return response()->json([
            'status' => false,
            'data'   => []
        ], 500);
    }

}
