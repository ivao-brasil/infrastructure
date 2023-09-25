<?php
namespace IvaoBrasil\Infrastructure\Models\Tracker;


use Illuminate\Database\Eloquent\Model;

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
