<?php

namespace App\Models\AccuracyScore;

use App\Models\AccuracyScore\Traits\Attribute;
use App\Models\AccuracyScore\Traits\Relationship;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccuracyScore extends Model
{
    use HasFactory, Attribute, Relationship;

    /**
     * @var string
     */
    public $table = 'accuracy_scores';

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
        'user_id',
        'admin_id',
        'username',
        'mod_flagged',
        'is_correct',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];


    public static function getHistoricalData($userId, $date) {
        $scores = static::whereDate('created_at', '=', $date)->with('user_accuracy_scores')
            ->where('user_id', $userId)->get();

        $mappedScores = $scores->map(function($e) {
            return [
                'id'          => $e['id'],
                'username'    => $e['username'],
                'mod_flagged' => $e['mod_flagged'],
                'is_correct'  => $e['is_correct'],
                'created_at'  => $e['created_at'],
                'updated_at'  => $e['updated_at'],
            ];
        });

        if($scores->count())
        {
            $score = $scores->first();

            return [
                'id'            => $score->user_accuracy_scores->id,
                'grading_admin' => $score->admin_id ? User::find($score->admin_id)->first(['name'])->name : 'Unknown',
                'data'          => $mappedScores,
                'accuracyGrade' => $score->user_accuracy_scores->accuracy_grade
            ];
        }

        return [];
    }
}
