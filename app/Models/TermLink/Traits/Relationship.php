<?php

namespace App\Models\TermLink\Traits;

use App\Models\Term\Term;


trait Relationship
{
    /**
     * Get the user associated with the Relationship
     */
    public function term()
    {
        return $this->belongsTo(Term::class, 'id', 'term_id');
    }
}
