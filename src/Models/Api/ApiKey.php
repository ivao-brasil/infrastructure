<?php

namespace IvaoBrasil\Infrastructure\Models\Api;

use Illuminate\Database\Eloquent\Model;

/**
 * IvaoBrasil\Infrastructure\Models\Api\ApiKey
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey query()
 * @property int $id
 * @property string $key
 * @property string $domain
 * @property int $limit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApiKey extends Model
{
    protected $visible = [
        "id", "key", "domain", "limit"
    ];

    protected $fillable = [
        "key", "domain", "limit"
    ];

    protected $table = "api_key";
}
