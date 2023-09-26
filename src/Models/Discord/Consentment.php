<?php

namespace IvaoBrasil\Infrastructure\Models\Discord;

use Illuminate\Database\Eloquent\Model;

/**
 * IvaoBrasil\Infrastructure\Models\Discord\Consentment
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Consentment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consentment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consentment query()
 * @mixin \Eloquent
 */
class Consentment extends Model
{
    protected $table = 'discord-consentment';

    protected $fillable = [
        "userVid",
        "discordId",
        "nickName",
        "roles",
        "division",
        "status"
    ];
}
