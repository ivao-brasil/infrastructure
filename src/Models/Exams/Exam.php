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
