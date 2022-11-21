<?php

namespace App\Http\Controllers\User\Dashboard;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\Trend\Trend;
use App\Models\Term\Term;
use Embed\Embed;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index() {
        $embed = new Embed();

        return inertia('Dashboard/Index', [
            'can-add-trend' => auth()->user()->can('add-trend')
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

        $trends = collect($trendsData);

        return response()->json([
            'status' => true,
            'trends' => $trends
        ]);
    }

}
