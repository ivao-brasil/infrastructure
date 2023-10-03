<?php

namespace IvaoBrasil\Infrastructure\Models\Trainings;
use Illuminate\Database\Eloquent\Model;

/**
 * IvaoBrasil\Infrastructure\Models\Trainings\TrainingType
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingType query()
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property int $minimum_rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingType whereMinimumRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TrainingType extends Model
{

}
