<?php

namespace IvaoBrasil\Infrastructure\Models\Api;

use Illuminate\Database\Eloquent\Model;

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
