<?php

namespace IvaoBrasil\Infrastructure\Models\Discord;

use Illuminate\Database\Eloquent\Model;

/**
 * IvaoBrasil\Infrastructure\Models\Discord\Consentment
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Consentment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consentment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consentment query()
 * @property int $id
 * @property string $userVid
 * @property string $discordId
 * @property string $nickName
 * @property string $roles
 * @property string $division
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Consentment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consentment whereDiscordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consentment whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consentment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consentment whereNickName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consentment whereRoles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consentment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consentment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consentment whereUserVid($value)
 * @mixin \Eloquent
 */
class Consentment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'discord-consentment';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
