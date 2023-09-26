<?php

namespace IvaoBrasil\Infrastructure\Models\TrainingSchedule;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use IvaoBrasil\Infrastructure\Factories\TrainingSchedule\TrainingSessionFactory;
use IvaoBrasil\Infrastructure\Models\Core\User;

/**
 * IvaoBrasil\Infrastructure\Models\TrainingSchedule\TrainingSession
 *
 * @property-read User|null $member
 * @property-read User|null $owner
 * @method static \IvaoBrasil\Infrastructure\Factories\TrainingSchedule\TrainingSessionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSession query()
 * @mixin \Eloquent
 */
class TrainingSession extends Model
{
    use HasFactory;

    protected $visible = [
        "id", "rating", "type", "occurrenceDate", "local", "owner", "member"
    ];
    protected $fillable = [
        "rating", "type", "occurrenceDate", "local", "owner_vid", "member_vid"
    ];
    protected $dates = [
        'occurrenceDate'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory<static>
     */
    protected static function newFactory(): Factory
    {
        return TrainingSessionFactory::new();
    }
}
