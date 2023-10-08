<?php

namespace IvaoBrasil\Infrastructure\Models\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use IvaoBrasil\Infrastructure\Models\Core\User;

/**
 * IvaoBrasil\Infrastructure\Models\Events\EventReportRemark
 *
 * @property-read User|null $owner
 * @property-read EventReportRemark|null $report
 * @method static \Illuminate\Database\Eloquent\Builder|EventReportRemark newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventReportRemark newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventReportRemark query()
 * @property int $id
 * @property int $report_id
 * @property string $remark
 * @property int $owner_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EventReportRemark whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventReportRemark whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventReportRemark whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventReportRemark whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventReportRemark whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventReportRemark whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventReportRemark extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events_reports_remarks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['report_id', 'remark', 'owner_id'];

    public function report(): HasOne
    {
        return $this->hasOne(EventReportRemark::class, 'id', 'report_id');
    }

    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'vid', 'owner_id');
    }
}
