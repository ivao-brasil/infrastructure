<?php

namespace IvaoBrasil\Infrastructure\Models\Api;

use Illuminate\Database\Eloquent\Model;

/**
 * IvaoBrasil\Infrastructure\Models\Api\ApiKey
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey query()
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
