<?php

namespace IvaoBrasil\Infrastructure\Models\Core;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\InvalidCastException;
use Illuminate\Database\Eloquent\MissingAttributeException;
use Illuminate\Database\LazyLoadingViolationException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use IvaoBrasil\Infrastructure\Factories\Core\UserFactory;
use JetBrains\PhpStorm\Deprecated;
use LogicException;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = "vid";
    public $incrementing = false;

    protected $fillable = [
        'vid', 'firstName', 'lastName', 'atcRating', 'pilotRating', 'division', 'country', 'staff'
    ];

    protected $visible = [
        'vid', 'firstName', 'lastName', 'atcRating', 'pilotRating', 'division', 'country', 'staff'
    ];

    protected $casts = [
        'staff' => 'array',
    ];

    #[Deprecated('Use $model->vid')]
    public function getVid(): string
    {
        return $this->getAttribute('vid');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory<static>
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }
}
