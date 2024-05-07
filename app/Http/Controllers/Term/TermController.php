<?php

namespace App\Http\Controllers\Term;

use App\Events\UpsertTermEvent;
use App\Models\Term\TermCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Term\Term;
use App\Models\TermLink\TermLink;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;
use MeiliSearch\Client;
use Throwable;

class TermController extends Controller
{
    /**
     * Meilisearch Client
     * @var Client
     */
    protected Client $client;

    /**
     * Terms Collection
     * @var Collection
     */
    protected Collection $terms;

    /**
     *  TermController Constructor
     */
    public function __construct() {
        $this->client   = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $this->terms    = Term::with(['categories','links'])->orderBy('term')->get();

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
     * @return Response
     */
    public function index($term = null) {
        return Inertia::render('SearchTerms/Index', [
            'can-add-term' => Auth::user()->can('add-term'),
            'categories'   => TermCategory::all()->toArray(),
            'routeTerm'    => $term ? Term::firstWhere('term', $term) : null
        ]);
    }

    /**
     * Get All Terms
     * @return Collection
     */
    public function getAllTerms() {
        return Term::with(['categories','links'])->orderBy('term')->get();
    }

    /**
     * Get All Terms
     * @return TermLink[]
     */
    public function getTermLinksById($id) {
        return TermLink::where('term_id', '=', $id)->get();
    }


    public function getAllTermCategories() {
        $terms    = Term::with('links')->orderBy('term', 'asc')->get();
        $cats     = TermCategory::with(['terms.categories', 'terms.links'])->orderBy('name')->get();
        $ids      = $cats->pluck('terms')->flatten()->pluck('id')->toArray();

        return [
            'all'           => $terms,
            'categories'    => $cats,
            'uncategorized' => $terms->whereNotIn('id', $ids)->all()
        ];
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
        $count = $data['count'] ?? 13;
        $terms = Cache::remember('terms:get-recent-terms', 30, fn() => Term::orderBy('updated_at', 'desc')->limit($count)->get()->toArray());

        return response()->json([
            'status' => true,
            'terms' => $terms
        ]);
    }

    /**
     * Add new term
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addTerm(Request $request) {
        $data = (array) json_decode($request->getContent());

        $validated = Validator::make($data, [
            'term'          => 'required|string',
            'rating'        => 'required|integer',
            'category'      => 'integer',
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

        $termObj = new Term([
            'term'        => $data['term'],
            'rating'      => $data['rating'],
            'description' => $data['description']
        ]);

        $termObj->categories()->sync([$data['category']]);

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

            $termObj->links()->saveMany($links);
        }

        if($res = $termObj->save())
        {
            event(new UpsertTermEvent($this->terms->take(12)->sortBy('updated_at', SORT_DESC)->toArray()));

            return response()->json([
                "status"    => true,
                "data"      => $termObj
            ]);
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
     * Update Term
     * @throws Throwable
     */
    public function updateTerm(Request $request) {

        $data = (array) json_decode($request->getContent());

        $validated = Validator::make($data, [
            'term'          => 'required|string',
            'rating'        => 'required|integer',
            'category'      => 'integer|string',
            'description'   => 'required|string'
        ]);

        // Validate the request
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

        if($data['category']) {
            $termObj->categories()->sync([$data['category']]);
        }

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

            $termLinks  = $termObj->links()->get()->map(function(TermLink $val) {
                return $val->format();
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
        $termObj['category'] = $data['category'];

        event(new UpsertTermEvent());

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
    public function searchTerm(Request $request)
    {
        $data   = $request->all();

        $this->client->index('terms')->updateSearchableAttributes([
            'term',
        ]);

        $res = $this->client->index('terms')->search($data['searchTerm'], [
            'limit' => 20000
        ]);

        return response()->json([
            'status' => true,
            'result' => $res->toArray()
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
