<?php

namespace IvaoBrasil\Infrastructure\Models\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use IvaoBrasil\Infrastructure\Models\Events\Event;
use IvaoBrasil\Infrastructure\Models\Core\User;

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
