<?php

namespace App\Models\Term\TermCategory\Link\Traits;

use App\Models\Term\Term;
use App\Models\Term\TermCategory;
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
    public function category()
    {
        return $this->hasOne(TermCategory::class, 'category_id');
    }
}
