<?php
namespace IvaoBrasil\Infrastructure\Models\Tracker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * IvaoBrasil\Infrastructure\Models\Tracker\Tracker
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \IvaoBrasil\Infrastructure\Models\Tracker\TrackerData> $data
 * @property-read int|null $data_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \IvaoBrasil\Infrastructure\Models\Tracker\Rule> $rules
 * @property-read int|null $rules_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tracker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tracker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tracker query()
 * @mixin \Eloquent
 */
class Tracker extends Model
{
    protected $table = 'tracker';

    protected $fillable = [
        'name', 'description', 'date_start', 'date_end', 'status', 'creator',
    ];

    public function rules(): HasMany
    {
        return $this->hasMany(Rule::class, 'id_tracker');
    }

    public function data(): HasMany
    {
        return $this->hasMany(TrackerData::class, 'id_tracker');
    }
}
