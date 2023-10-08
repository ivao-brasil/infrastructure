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
 * @property int $id
 * @property int $report_id
 * @property int $author_vid
 * @property string $contents
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ReportRemark whereAuthorVid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportRemark whereContents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportRemark whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportRemark whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportRemark whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportRemark whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReportRemark extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
