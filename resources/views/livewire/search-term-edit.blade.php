<div>
    <div class="spinner-grow text-primary" role="status" wire:loading.delay.long>
        <span class="visually-hidden">Loading...</span>
    </div>
    <div id="editPanel" class="row p-3" wire:loading.remove>
        <div class="col-6 mt-2">
            <label for="edit-rating" class="form-label">Rating <span id="edit-rangeval">{{ $term->rating ?? '1' }}</span></label>
            <input type="range" class="form-range" min="1" max="8" id="edit-rating" value="{{ $term->rating ?? 1 }}">
        </div>
        <div class="col-6  mt-2">
            <span>Date</span>
            <p id="edit-date" class="fs-6">{{ $term->created_at ?? '' }}</p>
        </div>
        <div class="col-12  mt-2">
            <input type="text" id="edit-term-val" class="edit-term-value form-control" placeholder="Term" value="{{ $term->term ?? '' }}">
        </div>
        <div class="col-12  mt-2">
            <textarea id="edit-description" class="form-control" rows="3" placeholder="Notes/Nuances (if any)">{{ $term->description ?? '' }}</textarea>
        </div>
        <div class="col-6 mt-2 float-right">
            <div class="input-group">
                <input type="text" id="edit-web-address-val" class="form-control" placeholder="Enter Web address..." aria-label="Enter Web address..." aria-describedby="edit-add-web-address-btn">
                <button class="btn btn-outline-secondary" type="button" id="edit-add-web-address-btn"><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>
        <div class="col-12 mt-2">
            <div id="edit-links-table" wire:model="links">
                {!! $linksTable !!}
            </div>
        </div>
        <div class="col-12 mt-2">
            <button id="save-term-edit-btn" type="button" class="btn btn-outline-success float-right"><i class="fa-regular fa-floppy-disk"></i> Save</button>
        </div>
    </div>
</div>

