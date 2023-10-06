<?php

namespace IvaoBrasil\Infrastructure\Models\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use IvaoBrasil\Infrastructure\Models\Core\User;

/**
 * IvaoBrasil\Infrastructure\Models\Events\Event
 *
 * @property-read User|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $tag
 * @property int $status
 * @property int $atc_reports
 * @property int $pilot_reports
 * @property int $pilot_award_id
 * @property int $atc_award_id
 * @property string $start_at
 * @property string $end_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $banner
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereAtcAwardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereAtcReports($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePilotAwardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePilotReports($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['created_by'];

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
