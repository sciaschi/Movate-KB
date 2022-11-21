<div>
    <div class="spinner-grow text-primary" role="status" wire:loading.delay.long>
        <span class="visually-hidden">Loading...</span>
    </div>
    <div id="detailsPanel" class="row p-3" wire:loading.remove>
        <div class="col-8">
        <span id="detailsTerm" class="fs-1 fw-bold">
            {{ $term->term ?? '' }}
            <span id="detailRatingSpan" class="fs-4">
                {{ $term->rating ?? '' }}
            </span>
        </span>
        </div>
        <div class="col-4 text-end">
            <span id="detailsDateAdded">{{ $term->created_at ?? '' }}</span>
            <p id="edit-term-btn-container" class="fs-3" wire:model="canEditTerm">
                <button id="edit-term-btn" type="button" class="btn btn-outline-primary" wire:click.prevent="edit()">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
            </p>
        </div>
        <div class="col-12 mb-3 mt-3">
            <div id="detailsDescription" class="p-6 bg-white dark:bg-slate-800 border-b border-gray-200 h-100 w-100">{!! $term->description ?? '' !!}</div>
        </div>
        <div class="col-12">
            <div id="detailsLinksTable" wire:model="links">
                {!! $linksTable !!}
            </div>
        </div>
    </div>
</div>
