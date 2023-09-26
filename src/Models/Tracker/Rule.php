<?php
namespace IvaoBrasil\Infrastructure\Models\Tracker;


use Illuminate\Database\Eloquent\Model;

/**
 * IvaoBrasil\Infrastructure\Models\Tracker\Rule
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Rule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rule query()
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
