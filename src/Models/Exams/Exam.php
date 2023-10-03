<?php

namespace IvaoBrasil\Infrastructure\Models\Exams;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use IvaoBrasil\Infrastructure\Models\Core\User;

/**
 * IvaoBrasil\Infrastructure\Models\Exams\Exam
 *
 * @property-read User|null $examiner
 * @property-read bool $can_archive
 * @property-read User|null $member
 * @property-write mixed $archived
 * @method static \Illuminate\Database\Eloquent\Builder|Exam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exam query()
 * @property int $id
 * @property int $member_vid
 * @property int|null $examiner_vid
 * @property string $rating
 * @property string $status
 * @property int|null $score
 * @property string|null $validator_comments
 * @property string|null $user_comments
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereArchived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereExaminerVid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereMemberVid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereUserComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereValidatorComments($value)
 * @mixin \Eloquent
 */
class Exam extends Model
{
    protected $casts = [
        'end_date' => 'datetime:Y-m-d H:00',
    ];

    public function examiner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCanArchiveAttribute(): bool
    {
        $isClosed = $this->status === 'finished' || $this->status === 'cancelled';
        return $isClosed && !$this->archived;
    }

    public function setArchivedAttribute(bool $value): void
    {
        if (!$this->can_archive && $value) {
            throw new \InvalidArgumentException('The exam could not be archived');
        }

        $this->attributes['archived'] = $value;
    }
}
