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
 * @property int $id
 * @property int $owner_vid
 * @property string $rating
 * @property string $type
 * @property \Illuminate\Support\Carbon $occurrenceDate
 * @property string $local
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $member_vid
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSession whereLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSession whereMemberVid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSession whereOccurrenceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSession whereOwnerVid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSession whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSession whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSession whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TrainingSession extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'occurrenceDate' => 'datetime'
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
