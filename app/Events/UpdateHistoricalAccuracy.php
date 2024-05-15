<?php

namespace App\Events;

use App\Models\UserAccuracyScore\UserAccuracyScore;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class UpdateHistoricalAccuracy
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public float $grade;

    /**
     * Create a new event instance.
     */
    public function __construct($userId)
    {
        $this->grade = UserAccuracyScore::find($userId)->pluck('accuracy_grade');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return ['update-historical-accuracy'];
    }
}
