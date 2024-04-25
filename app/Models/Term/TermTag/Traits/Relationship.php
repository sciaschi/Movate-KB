<?php

namespace App\Models\Term\TermTag\Traits;

use App\Models\Term\Term;

trait Relationship
{
    /**
     * Get all the tags for the Relationship
     */
    public function term()
    {
        return $this->hasOne(Term::class, 'term_id', 'id');
    }
}
