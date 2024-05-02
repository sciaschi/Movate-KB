<?php

namespace App\Models\Term\Traits;

use App\Models\Term\TermCategory;
use App\Models\Term\TermTag\Link\TermTagLink;
use App\Models\TermLink\TermLink;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Relationship
{
    /**
     * Get all the links for the Relationship
     * @return HasMany
     */
    public function links()
    {
        return $this->hasMany(TermLink::class, 'term_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function tags()
    {
        return $this->hasMany(TermTagLink::class, 'term_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(TermCategory::class, 'term_categories_link', 'term_id', 'category_id');
    }
}
