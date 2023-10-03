<?php

namespace IvaoBrasil\Infrastructure\Models\GCA;

use Illuminate\Database\Eloquent\Model;

/**
 * IvaoBrasil\Infrastructure\Models\GCA\GuestController
 *
 * @method static \Illuminate\Database\Eloquent\Builder|GuestController newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GuestController newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GuestController query()
 * @property int $id
 * @property int $vid
 * @property int $added_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|GuestController whereAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestController whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestController whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestController whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestController whereVid($value)
 * @mixin \Eloquent
 */
class GuestController extends Model
{
    protected $table = 'guest_controllers';
}
