<?php

namespace App\Models\Term\Traits;

use App\Models\TermLink\TermLink;

trait Relationship
{
    /**
     * Get all of the links for the Relationship
     */
    public function links()
    {
        return $this->hasMany(TermLink::class, 'term_id', 'id');
    }
}
