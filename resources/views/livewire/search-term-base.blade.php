<div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg w-100 d-inline-block" style="min-height: 100%;">
    <div class="p-6 bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-none h-100 w-100 d-inline-block">
        <div class="container">
            <div class="row">
                <div id="username_sidebar" class="col-xs-12 col-sm-12 col-md-4 bg-light shadow-sm sm:rounded-lg dark:bg-slate-700 dark:text-slate-400">
                    <div class="input-group mb-3">
                        <input id="search-input" wire:keyup.delay.1000ms="search" wire:model="searchValue" type="text" class="form-control search-input" placeholder="Search for term..." aria-describedby="search-input-button">
                        <button class="btn btn-outline-light bg-primary" type="button" id="search-input-button"><i class="fa-solid fa-plus"></i></button>
                    </div>

                    <div id="search_results_div">
                        <ul id="search_results" class="list-group list-group-flush" role="tablist">
                            @foreach($searchTerms as $searchTerm)
                                <a class='dark:bg-slate-800 dark:text-slate-400 dark:border dark:border-slate-700
                                active:bg-indigo-300 list-group-item list-group-item-action
                                term_search_value {{ $selectedTermId == $searchTerm['id'] ? 'active' : '' }}'
                                   data-id="{{$searchTerm['id']}}" wire:click.prevent="setTerm({{$searchTerm['id']}})">{{$searchTerm['term']}}</a>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8">
                    <div id="term-details" class="bg-light shadow-sm sm:rounded-lg w-100 dark:bg-slate-700 dark:text-slate-400" style="min-height: 100%;">
                        @if($editing)
                            @livewire('search-term-edit', ['term' => $selectedTerm])
                        @else
                            @livewire('search-term-details', ['term' => $selectedTerm])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
