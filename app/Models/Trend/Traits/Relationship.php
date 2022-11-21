<?php

namespace App\Models\Trend\Traits;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait Relationship
{
    /**
     * Get the user associated with the Relationship
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
