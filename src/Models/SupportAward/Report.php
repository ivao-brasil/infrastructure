<?php


namespace IvaoBrasil\Infrastructure\Models\SupportAward;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use IvaoBrasil\Infrastructure\Factories\SupportAward\ReportFactory;
use IvaoBrasil\Infrastructure\Models\Core\User;
use IvaoBrasil\Infrastructure\Models\TrainingSchedule\TrainingSession;
use JetBrains\PhpStorm\Deprecated;

/**
 * IvaoBrasil\Infrastructure\Models\SupportAward\Report
 *
 * @property-read User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \IvaoBrasil\Infrastructure\Models\SupportAward\ReportRemark> $remarks
 * @property-read int|null $remarks_count
 * @property-read TrainingSession|null $session
 * @method static \IvaoBrasil\Infrastructure\Factories\SupportAward\ReportFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report query()
 * @property int $id
 * @property string $connectionType
 * @property string $callsign
 * @property int $session_id
 * @property int $owner_vid
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCallsign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereConnectionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereOwnerVid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        "connectionType", "callsign", "status", "owner_vid", "session_id", "remarks"
    ];

    protected $visible = [
        "id", "connectionType", "callsign", "status", "session", "owner", "created_at", "updated_at", "session_id", "remarks"
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(TrainingSession::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    #[Deprecated('Use $model->owner')]
    public function getOwner(): User
    {
        return $this->getRelation('owner');
    }

    public function remarks(): HasMany
    {
        return $this->hasMany(ReportRemark::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory<static>
     */
    protected static function newFactory(): Factory
    {
        return ReportFactory::new();
    }
}
