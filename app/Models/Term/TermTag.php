<?php

namespace App\Models\Term;

use App\Models\Term\Traits\Attribute;
use App\Models\Term\Traits\Relationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;

class TermTag extends Model
{
    use HasFactory;

    use HasFactory, Attribute, Relationship, Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'term_tags';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

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
        'id',
        'name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Get the name of the index associated with the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'name';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    #[SearchUsingPrefix(['id', 'name'])]
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
