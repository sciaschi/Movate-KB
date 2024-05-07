<?php

namespace App\Http\Controllers\Trend;

use App\Events\TrendsUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Models\Term\Term;
use App\Models\Trend\Trend;
use Embed\Embed;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TrendController extends Controller
{
    /**
     * getAllTrends
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getTrends(Request $request) {
        $data   = $request->all();

        $count  = $data['count'] ?? 6;
        $trends = Cache::remember('trends', 60, fn() => Trend::getRecentTrends($count));

        return response()->json([
            'status' => true,
            'trends' => $trends
        ]);
    }

    /**
     * @param $request Request
     * @return JsonResponse
     */
    public function storeTrendUrl(Request $request) {

        $validationRules = [
            'url' => 'required|unique:trends|url'
        ];

        $validated = $request->validate($validationRules);

        $data = $request->all();

        if(!$validated) {
            return response()->json([
                "status" => false,
                "message" => $validated->message
            ], 500);
        }

        $embed  = new Embed();
        $info   = $embed->get($data['url']);
//        Trend::removeOldTrends();

        $newTrend           = new Trend();
        $newTrend->title    = $info->title;
        $newTrend->url      = $data['url'];
        $newTrend->image    = $info->image;

        $status = $newTrend->save();

        if($newTrend->id) {
            event(new TrendsUpdatedEvent());

            return response()->json([
                "status" => true,
                "trend_id" => $newTrend->id
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => $status->message
            ], 500);
        }

    }
}
