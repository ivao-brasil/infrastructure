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
 * @property int $id
 * @property int $vid
 * @property string $position
 * @property \Illuminate\Support\Carbon $appointed_at
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $active
 * @method static \Illuminate\Database\Eloquent\Builder|StaffAppointment whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffAppointment whereAppointedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffAppointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffAppointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffAppointment wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffAppointment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffAppointment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffAppointment whereVid($value)
 * @mixin \Eloquent
 */
class StaffAppointment extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'appointed_at' => 'datetime',
        'active' => 'boolean',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vid', 'vid');
    }
}
