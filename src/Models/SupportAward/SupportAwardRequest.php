<?php
namespace IvaoBrasil\Infrastructure\Models\SupportAward;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use IvaoBrasil\Infrastructure\Models\Core\User;

class SupportAwardRequest extends Model
{
    protected $table = "support_award_requests";

    protected $fillable = [
        "member_vid", "type", "level", "granted"
    ];

    protected $visible = [
        "id", "member_vid", "member", "type", "level", "granted", "created_at", "updated_at"
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
