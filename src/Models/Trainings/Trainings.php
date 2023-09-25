<?php

namespace IvaoBrasil\Infrastructure\Models\Trainings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use IvaoBrasil\Infrastructure\Models\Core\User;

class Trainings extends Model
{
    protected $casts = [
        'end_date' => 'datetime:Y-m-d H:00',
    ];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type(): HasOne
    {
        return $this->hasOne(TrainingType::class, 'id', 'training_type_id');
    }
}
