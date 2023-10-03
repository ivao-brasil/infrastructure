<?php

namespace IvaoBrasil\Infrastructure\Models\Ais;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use IvaoBrasil\Infrastructure\Models\Core\User;

/**
 * IvaoBrasil\Infrastructure\Models\Ais\AisAirport
 *
 * @property-read User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|AisAirport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AisAirport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AisAirport query()
 * @property int $id
 * @property string $icao
 * @property mixed|null $rwy_configuration
 * @property mixed|null $rmk
 * @property int $active
 * @property int $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AisAirport whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AisAirport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AisAirport whereIcao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AisAirport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AisAirport whereRmk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AisAirport whereRwyConfiguration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AisAirport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AisAirport whereUpdatedBy($value)
 * @mixin \Eloquent
 */
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
