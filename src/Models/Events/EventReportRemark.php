<?php

namespace IvaoBrasil\Infrastructure\Models\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use IvaoBrasil\Infrastructure\Models\Core\User;

class EventReportRemark extends Model
{
    protected $table = 'events_reports_remarks';
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
