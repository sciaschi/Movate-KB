<?php

namespace App\Http\Livewire;

use App\Models\Term\Term;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use MeiliSearch\Client;

class SearchTermBase extends Component
{
    public $editing = false;
    public Collection $terms;
    public $searchTerms;
    public string $searchValue = '';
    public int $selectedTermId;
    public Term $selectedTerm;

    protected Client $client;

    protected $listeners = [
        'setActiveState',
        '$refresh'
    ];

    public function boot() {
        $this->client       = new Client($_SERVER['SERVER_NAME'] . ":7700");
        $this->selectedTerm = new Term();
    }

    public function mount() {
        $this->search();
    }

    public function setTerm($value)
    {
        $this->selectedTerm = Term::findOrFail($value);

        return false;
    }

    public function setActiveState($value)
    {
        if(!is_null($value))
        {
            $this->activeState = $value;
        }

        $this->emitSelf('$refresh');

        return false;
    }

    public function search() {
        $this->searchTerms = $this->client->index('terms')->search($this->searchValue)->getHits();
        return $this->searchTerms;
    }

    public function render()
    {
        return view('livewire.search-term-base');

    }
}
