<?php

namespace IvaoBrasil\Infrastructure\Models\HQ;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use IvaoBrasil\Infrastructure\Models\Core\User;

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
