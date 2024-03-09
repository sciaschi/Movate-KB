<?php

namespace App\Models\AccuracyScore\Traits;

use App\Models\UserAccuracyScore\UserAccuracyScore;

trait Relationship
{
    public function user_accuracy_scores() {
        return $this->hasOne(UserAccuracyScore::class, 'user_id', 'user_id');
    }
}
