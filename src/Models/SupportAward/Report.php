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
