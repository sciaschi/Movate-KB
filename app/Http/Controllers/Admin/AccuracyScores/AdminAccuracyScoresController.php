<?php

namespace App\Http\Controllers\Admin\AccuracyScores;

use App\Http\Controllers\Controller;
use App\Models\AccuracyScore\AccuracyScore;
use App\Models\Term\Term;
use App\Models\User\User;
use App\Models\UserAccuracyScore\UserAccuracyScore;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Validator;

class AdminAccuracyScoresController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index() {
        return Inertia::render('Admin/AccuracyScores/Index');
    }

    /**
     * @return \Inertia\Response
     */
    public function historical($id) {
        return Inertia::render('Admin/AccuracyScores/Historical', [
            'user' => User::whereHashId($id)->first(['name'])->name
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getHistoricalData(Request $request) {
        $data = $request->all();
        $scores = AccuracyScore::whereDate('created_at', '=', $data['filter_date'])->with('user_accuracy_scores')
            ->where('user_id', User::keyFromHashId($data['user_id']))->get();

        $mappedScores = $scores->map(function($e) {
            return [
                'username'    => $e['username'],
                'mod_flagged' => $e['mod_flagged'],
                'is_correct'  => $e['is_correct'],
                'created_at'  => $e['created_at'],
                'updated_at'  => $e['updated_at'],
            ];
        });

        if($scores->count())
        {
            return response()->json([
                'status'        => true,
                'grading_admin' => User::where('id', $scores->first()->admin_id)->first(['name'])->name,
                'data'          => $mappedScores,
                'accuracyGrade' => $scores->first()->user_accuracy_scores->accuracy_grade
            ]);
        }

        return response()->json([
            'status' => true,
            'data'   => [],
        ]);
    }

    /**
     * @param \Request $request
     * @param $id
     * @return \Inertia\Response
     */
    public function grade(Request $request, $id) {
        return Inertia::render('Admin/AccuracyScores/Grade', [
            'gradingUser' => User::whereHashId($id)->get(['id', 'name'])
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createAccuracyScore(Request $request) {
        $data = $request->all();

        $addData = collect($data['data'])->map(function($el) use ($data) {
            return [
                'user_id'     => $data['user_id'],
                'admin_id'    => auth()->user()->id,
                'username'    => $el['username'],
                'mod_flagged' => $el['mod_flagged'],
                'is_correct'  => $el['is_correct'],
                'created_at'  => Carbon::Now()
            ];
        })->toArray();

        if($res = AccuracyScore::insert($addData))
        {
            $userAccScore                 = new UserAccuracyScore();
            $userAccScore->user_id        = $data['user_id'];
            $userAccScore->accuracy_grade = $data['accuracy'];
            $userAccScore->created_at     = Carbon::Now();

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
}
