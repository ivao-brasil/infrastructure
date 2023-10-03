<?php
namespace IvaoBrasil\Infrastructure\Models\Tracker;


use Illuminate\Database\Eloquent\Model;

/**
 * IvaoBrasil\Infrastructure\Models\Tracker\Rule
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Rule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rule query()
 * @property int $id
 * @property int $id_tracker
 * @property string $client_type
 * @property string $rule_type
 * @property string $params
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereClientType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereIdTracker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereRuleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Rule extends Model
{
    protected $table = 'tracker_rules';

    protected $fillable = [
        'id_tracker',
        'client_type',
        'rule_type',
        'params'
    ];
}
