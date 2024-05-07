<?php

namespace App\Events;

use App\Models\Term\Term;
use App\Models\Term\TermCategory;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class UpsertTermEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Collection $terms;

    /**
     * Create a new event instance.
     */
    public function __construct($count = 13)
    {
        $this->terms = Term::getTrendingNews($count);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return ['recent-terms'];
    }
}
