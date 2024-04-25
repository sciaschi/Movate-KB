<?php

namespace App\Models\Term\TermCategory\Traits;

use App\Models\TermLink\TermLink;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Relationship
{
    /**
     * @return HasMany
     */
    public function links()
    {
        return $this->hasMany(TermLink::class, 'term_id', 'id');
    }
}
