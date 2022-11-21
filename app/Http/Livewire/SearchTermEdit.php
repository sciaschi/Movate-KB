<?php

namespace App\Http\Livewire;

use App\Helpers\TableBuilder;
use App\Models\Term\Term;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class SearchTermEdit extends Component
{
    public array|Collection $links;
    public string $linksTable;

    protected TableBuilder $tableBuilder;
    protected $listeners = ['setTerm'];

    public function boot() {
        $this->tableBuilder = new TableBuilder([], []);
    }

    public function render()
    {
        $this->tableBuilder = new TableBuilder([
            [
                'name'      => 'Useful Links',
                'id'        => 'link_url',
                'classList' => 'bg-red'
            ],
            [
                'name'      => 'Actions',
                'id'        => 'html',
                'html'      => function($data) {
                    return '<i class="fa-solid fa-xmark"></i>';
                }
            ]
        ], $this->links);

        $this->linksTable = $this->tableBuilder->make();

        return view('livewire.search-term-edit');
    }
}
