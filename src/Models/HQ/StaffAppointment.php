<?php

namespace IvaoBrasil\Infrastructure\Models\HQ;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use IvaoBrasil\Infrastructure\Models\Core\User;

/**
 * IvaoBrasil\Infrastructure\Models\HQ\StaffAppointment
 *
 * @property-read User|null $staff
 * @method static \Illuminate\Database\Eloquent\Builder|StaffAppointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffAppointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffAppointment query()
 * @mixin \Eloquent
 */
class StaffAppointment extends Model
{
    protected $visible = ['id', 'vid', 'position', 'appointed_at', 'status', 'active'];

    protected $fillable = ['vid', 'position', 'status', 'active', 'appointed_at'];

    protected $dates = [
        'appointed_at'
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
