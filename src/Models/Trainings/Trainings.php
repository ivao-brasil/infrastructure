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
