<?php

namespace IvaoBrasil\Infrastructure\Models\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use IvaoBrasil\Infrastructure\Models\Core\DivisionAward;
use IvaoBrasil\Infrastructure\Models\Core\User;

class EventRequestAward extends Model
{
    protected $table = 'events_request_award';

    public function member(): HasOne
    {
        return $this->hasOne(User::class, 'vid', 'member_vid');
    }

    public function award(): HasOne
    {
        return $this->hasOne(DivisionAward::class, 'id', 'award_id');
    }
}
