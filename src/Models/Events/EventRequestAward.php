<?php

namespace IvaoBrasil\Infrastructure\Models\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use IvaoBrasil\Infrastructure\Models\Core\DivisionAward;
use IvaoBrasil\Infrastructure\Models\Core\User;

/**
 * IvaoBrasil\Infrastructure\Models\Events\EventRequestAward
 *
 * @property-read DivisionAward|null $award
 * @property-read User|null $member
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequestAward newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequestAward newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequestAward query()
 * @property int $id
 * @property int $event_id
 * @property int $member_vid
 * @property int $award_id
 * @property int $granted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequestAward whereAwardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequestAward whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequestAward whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequestAward whereGranted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequestAward whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequestAward whereMemberVid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequestAward whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
