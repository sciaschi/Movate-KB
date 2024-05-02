<?php

namespace App\Models\Term\TermCategory\Link;

use App\Models\Term\TermCategory\Link\Traits\Relationship;
use App\Models\Term\TermCategory\Link\Traits\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Laravel\Scout\Searchable;

class TermCategoryLink extends Pivot
{
    use HasFactory, Attribute, Relationship, Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'term_categories_link';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'term_id',
        'category_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];
}
