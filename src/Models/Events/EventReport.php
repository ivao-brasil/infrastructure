<?php

namespace IvaoBrasil\Infrastructure\Models\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use IvaoBrasil\Infrastructure\Models\Events\Event;
use IvaoBrasil\Infrastructure\Models\Core\User;

/**
 * IvaoBrasil\Infrastructure\Models\Events\EventReport
 *
 * @property-read Event|null $event
 * @property-read User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \IvaoBrasil\Infrastructure\Models\Events\EventReportRemark> $remarks
 * @property-read int|null $remarks_count
 * @method static \Illuminate\Database\Eloquent\Builder|EventReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventReport query()
 * @mixin \Eloquent
 */
class EventReport extends Model
{
    protected $table = 'events_report';

    public function remarks(): HasMany
    {
        return $this->hasMany(EventReportRemark::class, 'report_id', 'id');
    }

    public function event(): HasOne
    {
        return $this->hasOne(Event::class, 'id', 'event_id');
    }

    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'vid', 'owner_id');
    }
}
