<?php
namespace IvaoBrasil\Infrastructure\Models\SupportAward;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use IvaoBrasil\Infrastructure\Models\Core\User;

/**
 * IvaoBrasil\Infrastructure\Models\SupportAward\SupportAwardRequest
 *
 * @property-read User|null $member
 * @method static \Illuminate\Database\Eloquent\Builder|SupportAwardRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportAwardRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportAwardRequest query()
 * @property int $id
 * @property int $member_vid
 * @property string $type
 * @property string $level
 * @property int $granted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SupportAwardRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportAwardRequest whereGranted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportAwardRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportAwardRequest whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportAwardRequest whereMemberVid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportAwardRequest whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportAwardRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
