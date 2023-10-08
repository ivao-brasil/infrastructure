<?php

namespace IvaoBrasil\Infrastructure\Models\Core;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use IvaoBrasil\Infrastructure\Data\User\AtcRating;
use IvaoBrasil\Infrastructure\Data\User\PilotRating;
use IvaoBrasil\Infrastructure\Factories\Core\UserFactory;
use JetBrains\PhpStorm\Deprecated;
use Spatie\Permission\Traits\HasRoles;

/**
 * IvaoBrasil\Infrastructure\Models\Core\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \IvaoBrasil\Infrastructure\Factories\Core\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @property int $vid
 * @property string $firstName
 * @property string $lastName
 * @property int $atcRating
 * @property int $pilotRating
 * @property string $division
 * @property string $country
 * @property array $staff
 * @property string $full_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAtcRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePilotRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStaff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVid($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'vid';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'staff' => 'array',
        'atcRating' => AtcRating::class,
        'pilotRating' => PilotRating::class,
    ];

    /**
     * Retrieves the full name from the given attributes.
     *
     * @return Attribute
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (?mixed $value, array $attributes) => "{$attributes['firstName']} {$attributes['lastName']}",
        );
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
