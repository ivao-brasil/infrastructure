<?php

namespace IvaoBrasil\Infrastructure\Models\Tracker;


use Illuminate\Database\Eloquent\Model;

/**
 * IvaoBrasil\Infrastructure\Models\Tracker\TrackerData
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData query()
 * @property int $id
 * @property int $id_tracker
 * @property string $vid
 * @property string $callsign
 * @property string $client_type
 * @property string $departure
 * @property string $destination
 * @property string $connection_time
 * @property string $last_position_time
 * @property int $total_time
 * @property string $first_position
 * @property string $last_position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $metadata
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData whereCallsign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData whereClientType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData whereConnectionTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData whereDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData whereDestination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData whereFirstPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData whereIdTracker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData whereLastPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData whereLastPositionTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData whereTotalTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrackerData whereVid($value)
 * @mixin \Eloquent
 */
class TrackerData extends Model
{
    protected $table = 'tracker_data';

    protected $fillable = [
        'id_tracker',
        'vid',
        'callsign',
        'client_type',
        'departure',
        'destination',
        'connection_time',
        'last_position_time',
        'total_time',
        'first_position',
        'last_position',
        'metadata'
    ];
}
