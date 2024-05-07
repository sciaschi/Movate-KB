<?php

namespace App\Models\TermLink;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TermLink\Traits\Attribute;
use App\Models\TermLink\Traits\Relationship;

class TermLink extends Model
{
    use HasFactory, Attribute, Relationship;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'term_links';

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
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'term_id',
        'link_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Format Links
     * @return array
     */
    public function format() {
        return [
            'id'       => isset($this->id) ? intval($this->id) : 0,
            'link_url' => strip_tags($this->link_url),
            'term_id'  => intval($data['id']) ?? $this['id']
        ];
    }
}
