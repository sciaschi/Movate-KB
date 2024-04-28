<?php

namespace App\Models\Term\TermCategory\Traits;

use App\Models\Term\Term;
use App\Models\Term\TermCategory\Link\TermCategoryLink;
use App\Models\TermLink\TermLink;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

trait Relationship
{
    /**
     * @return hasManyThrough
     */
    public function terms()
    {
        return $this->hasManyThrough(Term::class, TermCategoryLink::class, 'category_id', 'id', 'id', 'term_id');
    }
    /**
     * @return HasMany
     */
    public function links()
    {
        return $this->hasMany(TermLink::class, 'term_id', 'id');
    }
}
