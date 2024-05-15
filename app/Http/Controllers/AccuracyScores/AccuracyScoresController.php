<?php

namespace App\Http\Controllers\AccuracyScores;

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

class AccuracyScoresController extends Controller
{
    /**
     * @return Response
     */
    public function index() {
        return Inertia::render('UserAudits/Index');
    }


    /**
     * @return JsonResponse
     */
    public function getHistoricalData(Request $request) {
        $data = $request->all();
//        $ordering = $data['ordering'];
        $scores = AccuracyScore::whereDate('created_at', '=', $data['filter_date'])->with('user_accuracy_scores')
            ->where('user_id', $data['user_id'])->orderBy('username', 'asc')->paginate(15)->withQueryString()->through(function($item) {
                return [
                    'id'          => $item['id'],
                    'username'    => $item['username'],
                    'mod_flagged' => $item['mod_flagged'],
                    'is_correct'  => $item['is_correct'],
                    'created_at'  => $item['created_at'],
                    'updated_at'  => $item['updated_at'],
                ];
            });

        if($scores->count()) {
            $score = $scores->first();
            return response()->json([
                'status'        => true,
//                'grading_admin' => $score->admin_id ? User::find($score->admin_id)->first(['name'])->name : 'Unknown',
                'data'          => $scores,
//                'accuracyGrade' => $score->user_accuracy_scores->accuracy_grade
            ]);
        }

        return response()->json([
            'status'        => false,
            'data'          => [],
        ]);
    }
}
