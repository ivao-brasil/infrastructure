<?php

namespace IvaoBrasil\Infrastructure\Models\Trainings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use IvaoBrasil\Infrastructure\Models\Core\User;

/**
 * IvaoBrasil\Infrastructure\Models\Trainings\Trainings
 *
 * @property-read User|null $member
 * @property-read User|null $trainer
 * @property-read \IvaoBrasil\Infrastructure\Models\Trainings\TrainingType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|Trainings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trainings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trainings query()
 * @property int $id
 * @property int $member_vid
 * @property int|null $trainer_vid
 * @property int|null $training_type_id
 * @property string $status
 * @property string|null $internal_comments
 * @property string|null $user_comments
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Trainings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trainings whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trainings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trainings whereInternalComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trainings whereMemberVid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trainings whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trainings whereTrainerVid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trainings whereTrainingTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trainings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trainings whereUserComments($value)
 * @mixin \Eloquent
 */
class Trainings extends Model
{
    protected $casts = [
        'end_date' => 'datetime:Y-m-d H:00',
    ];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type(): HasOne
    {
        return $this->hasOne(TrainingType::class, 'id', 'training_type_id');
    }
}
