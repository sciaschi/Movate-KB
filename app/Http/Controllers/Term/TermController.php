<?php

namespace App\Http\Controllers\Term;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Term\Term;
use App\Models\TermLink\TermLink;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use MeiliSearch\Client;
use Throwable;

class TermController extends Controller
{
    /**
     * Meilisearch Client
     * @var Client
     */
    private Client $client;

    /**
     * Terms Collection
     * @var Collection
     */
    private Collection $terms;

    /**
     *  TermController Constructor
     */
    public function __construct() {
        $this->client   = new Client($_SERVER['SERVER_NAME'] . ":7700");
        $this->terms    = Term::with('links')->orderBy('term')->get();

        $unJson = json_decode($this->terms->toJson());

        $this->client->index('terms')->deleteAllDocuments();

        if($this->client->index('terms'))
        {
            $this->client->index('terms')->updateDocuments($unJson);
        }
        else
        {
            $this->client->index('terms')->addDocuments($unJson);
        }
    }

    /**
     * Index Page
     * @return \Inertia\Response
     */
    public function index() {
        return Inertia::render('SearchTerms/Index', [
            'can-add-term' => auth()->user()->can('add-term')
        ]);
    }

    /**
     * Get All Terms
     * @return Term[]
     */
    public function getAllTerms() {
        return Term::with('links')->orderBy('term', 'asc')->get();
    }

    /**
     * Get All Terms
     * @return \LaravelIdea\Helper\App\Models\TermLink\_IH_TermLink_C|TermLink[]
     */
    public function getTermLinksById($id) {
        return TermLink::where('term_id', '=', $id)->get();
    }

    /**
     * Update Term
     * @throws Throwable
     */
    public function updateTerm(Request $request) {

        $data = (array) json_decode($request->getContent());

        $validated = Validator::make($data, [
            'term'          => 'required|string',
            'rating'        => 'required|integer',
            'description'   => 'required|string'
        ]);

        // Validate the request...
        if($validated->fails())
        {
            return response()->json([
                "status" => false,
                "message" => $validated->errors()->all()
            ], 500);
        }

        $termObj = Term::with('links')->find($data['id']);

        $termObj->term          = $data['term'];
        $termObj->rating        = $data['rating'];
        $termObj->description   = $data['description'];

        $links = [];

        if(isset($data['links']))
        {
            foreach($data['links'] as $link) {
                $links[] = [
                    'id'       => isset($link->id) ? intval($link->id) : 0,
                    'link_url' => strip_tags($link->link_url),
                    'term_id'  => intval($data['id']) ?? $data['id']
                ];
            }

            $links = collect($links);

            $termLinks  = $termObj->links()->get()->map(function($val) {
                return [
                    'id' => $val->id,
                    'link_url' => $val->link_url,
                    'term_id' => $val->term_id,
                ];
            });

            $addLinks = $links->whereNotIn('id', $termLinks->pluck('id'));
            $removeLinks = $termLinks->whereNotIn('id', $links->pluck('id'));

            $addLinks = $addLinks->map(function($val) {
               return new TermLink($val);
            });

            if($removeLinks->count())
            {
                $termObj->links()->whereIn('id', $removeLinks->pluck('id'))->delete();
            }

            $termObj->links()->saveMany($addLinks);
        }

        $termObj->save();
        $termObj->refresh();

        return response()->json([
            "status"    => true,
            "data"      => $termObj
        ]);
    }

    /**
     * Get Recently Added Trends Sorted by created_at desc
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getRecentlyAddedTerms(Request $request)
    {
        $data   = $request->all();
        $count = $data['count'] ?? 12;
        $termsData = Term::orderBy('created_at', 'desc')->limit($count)->get();

        $terms = collect($termsData);

        return response()->json([
            'status' => true,
            'terms' => $terms
        ]);
    }

    /**
     * Store a new Term in the database.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'term' => 'required|unique:terms|string',
            'rating' => 'required|integer',
            'description' => 'required|string'
        ]);

        if(!$validated)
        {
            return response()->json([
                "status" => false,
                "message" => $validated->message
            ], 500);
        }

        $data = $request->all();

        // Validate the request...
        $termObj = new Term();

        $termObj->term = $data['term'];
        $termObj->rating = $data['rating'];
        $termObj->description = $data['description'];

        $termObj->save();

        if(isset($data['links']))
        {
            $links          = [];

            $flattenedLinks = collect($data['links'])->flatten()->all();

            foreach($flattenedLinks as $link) {
                $links[] = new TermLink([
                    'link_url' => $link
                ]);
            }

            $termObj->links()->saveMany($links);
        }
        return response()->json([
            "status"    => true,
            "data"      => $termObj
        ]);
    }

}
