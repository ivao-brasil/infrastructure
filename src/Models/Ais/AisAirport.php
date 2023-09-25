<?php

namespace IvaoBrasil\Infrastructure\Models\Ais;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use IvaoBrasil\Infrastructure\Models\Core\User;

class AisAirport extends Model
{
    protected $visible = [
        "id", "icao", "rwy_configuration", "rmk", "updated_by", "active"
    ];

    protected $fillable = [
        "icao", "rwy_configuration", "rmk", "updated_by", "active"
    ];

    protected $table = "ais_airports";

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
