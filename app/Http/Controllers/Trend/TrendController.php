<?php

namespace App\Http\Controllers\Trend;

use App\Http\Controllers\Controller;
use App\Models\Trend\Trend;
use Embed\Embed;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrendController extends Controller
{

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

        if(!$validated)
        {
            return response()->json([
                "status" => false,
                "message" => $validated->message
            ], 500);
        }

        $embed  = new Embed();
        $info   = $embed->get($data['url']);

        $newTrend           = new Trend();
        $newTrend->title    = $info->title;
        $newTrend->url      = $data['url'];

        $status = $newTrend->save();

        if($newTrend->id)
        {
            return response()->json([
                "status" => true,
                "trend_id" => $newTrend->id
            ]);
        }
        else
        {
            return response()->json([
                "status" => false,
                "message" => $status->message
            ], 500);
        }

    }

    /**
     * getAllTrends
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getTrends(Request $request)
    {
        $embed = new Embed();

        $data   = $request->all();

        $count  = $data['count'] ?? 6;
        $trends = Trend::orderBy('created_at', 'desc')->limit($count)->get();

        $trendsData = [];

        foreach($trends as $trend) {
            $info = $embed->get($trend->url);
            $trendsData[] = [
                'title' => $info->title,
                'url' => $trend->url,
                'image' => $info->image
            ];
        }

        return response()->json([
            'status' => true,
            'trends' => collect($trendsData)
        ]);
    }
}
