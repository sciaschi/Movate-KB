<?php

namespace App\Models\User\Traits;

use App\Models\UserAccuracyScore\UserAccuracyScore;

trait Relationship
{
    public function accuracy_scores() {
        return $this->hasMany(UserAccuracyScore::class, 'user_id', 'id');
    }
}
