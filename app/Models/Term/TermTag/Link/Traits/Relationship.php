<?php

namespace App\Models\Term\TermTag\Link\Traits;

use App\Models\Term\Term;
use App\Models\Term\TermTag;

trait Relationship
{
    /**
     * Get all the tags for the Relationship
     */
    public function term()
    {
        return $this->hasOne(Term::class, 'term_id');
    }

    /**
     * Get all the tags for the Relationship
     */
    public function tag()
    {
        return $this->hasOne(TermTag::class, 'tag_id');
    }
}
