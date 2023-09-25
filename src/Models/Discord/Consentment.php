<?php

namespace IvaoBrasil\Infrastructure\Models\Discord;

use Illuminate\Database\Eloquent\Model;

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
