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
 * @property string $appointed_at
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $active
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
