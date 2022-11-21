<?php

namespace App\Http\Livewire;

use App\Models\Term\Term;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class RecentlyAddedTermsComponent extends Component
{
    public Collection $terms;

    public function mount() {
        $this->refresh();
    }

    public function refresh() {
        $values         = Term::orderBy('created_at', 'desc')->limit(12)->get();
        $this->terms    = $values;
    }

    public function render()
    {
        return view('livewire.recently-added-terms-component',[
            'terms' => $this->terms
        ]);
    }
}
