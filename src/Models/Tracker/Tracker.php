<?php
namespace IvaoBrasil\Infrastructure\Models\Tracker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
