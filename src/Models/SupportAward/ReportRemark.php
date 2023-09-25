<?php


namespace IvaoBrasil\Infrastructure\Models\SupportAward;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use IvaoBrasil\Infrastructure\Models\Core\User;

class ReportRemark extends Model
{
    protected $fillable = [
        "report_id", "author_vid", "contents"
    ];

    protected $visible = [
        "id", "report_id", "author_vid", "contents", "created_at", "updated_at"
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
