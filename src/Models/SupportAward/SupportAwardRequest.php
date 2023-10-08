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
 * @property bool $granted
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
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "support_award_requests";

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'granted' => 'boolean',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
