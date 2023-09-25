<?php

namespace IvaoBrasil\Infrastructure\Models\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use IvaoBrasil\Infrastructure\Models\Core\User;

class Event extends Model
{
    protected $table = 'events';

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
