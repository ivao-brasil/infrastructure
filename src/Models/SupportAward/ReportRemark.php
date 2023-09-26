<?php


namespace IvaoBrasil\Infrastructure\Models\SupportAward;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use IvaoBrasil\Infrastructure\Models\Core\User;

/**
 * IvaoBrasil\Infrastructure\Models\SupportAward\ReportRemark
 *
 * @property-read User|null $author
 * @method static \Illuminate\Database\Eloquent\Builder|ReportRemark newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportRemark newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportRemark query()
 * @mixin \Eloquent
 */
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
