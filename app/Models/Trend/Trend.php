<?php

namespace App\Models\Trend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trend\Traits\Attribute;
use App\Models\Trend\Traits\Relationship;
use Illuminate\Support\Facades\DB;

class Trend extends Model
{
    use HasFactory, Attribute, Relationship;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trends';

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
        'title',
        'url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public static function getRecentTrends($count = 6) {
        return static::orderBy('created_at', 'desc')->limit($count)->get()->map(fn($trend) => $trend->format());
    }

    public function format() {
        return [
            'title' => $this->title,
            'url'   => $this->url,
            'image' => $this->image
        ];
    }

    public static function removeOldTrends() {
        $removeId = static::select(['id'])->orderByDesc('id')->limit(6)->min('id');
        static::where('id', '<=', $removeId)->delete();
    }
}
