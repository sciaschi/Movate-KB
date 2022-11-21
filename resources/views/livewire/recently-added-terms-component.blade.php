<div id="recent-terms-container" class="container pt-3" wire:poll.30000ms="refresh">
    <div id="rt-grid" class="row align-items-stretch">
        @foreach ($terms as $term)
            <div class="col-md-6 col-sm-12 col-lg-4 col-xl-4 h-100 mb-3 align-middle">
                <div class="card ra-term dark:bg-slate-700 dark:text-slate-400" data-bs-toggle="popover" data-bs-placement="top"
                     data-bs-title="{{$term->term}}"
                     data-bs-content="{{Str::of($term->description)->limit(250)}}"
                     data-id="{{$term->id}}">
                    <div class="card-body">
                        <span class="recentlyAddedTermDate float-end w-30">{{ $term->created_at }}</span>
                        <span>{{ Str::of($term->term)->limit(20) }}</span> <span class="recentlyAddedTermRating float-end">{{ $term->rating }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

