<?php

namespace App\Http\Livewire;

use App\Helpers\TableBuilder;
use App\Models\Term\Term;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class SearchTermDetails extends Component
{
    public Term $term;
    public bool $canEditTerm = false;
    protected $listeners = ['setTerm'];
    protected TableBuilder $tableBuilder;
    public array|Collection $links;
    public string $linksTable;

    public function boot() {

        $this->canEditTerm  = auth()->user()->can('edit-terms');
        $this->tableBuilder = new TableBuilder([], []);
    }

    public function edit() {
        $this->emitUp('setActiveState', 'edit');
    }

    public function render()
    {
        return view('livewire.search-term-details',[
            'linksTable' => $this->tableBuilder,
            'term'       => $this->term
        ]);
    }
}
