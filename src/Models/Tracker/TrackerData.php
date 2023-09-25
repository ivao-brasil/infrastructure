<?php

namespace IvaoBrasil\Infrastructure\Models\Tracker;


use Illuminate\Database\Eloquent\Model;

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
