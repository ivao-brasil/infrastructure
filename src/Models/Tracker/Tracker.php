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
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $date_start
 * @property string $date_end
 * @property string $status
 * @property string $creator
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Tracker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tracker whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tracker whereDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tracker whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tracker whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tracker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tracker whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tracker whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tracker whereUpdatedAt($value)
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
