<?php


namespace IvaoBrasil\Infrastructure\Models\Academy;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use IvaoBrasil\Infrastructure\Factories\Academy\TagFactory;

/**
 * IvaoBrasil\Infrastructure\Models\Academy\Tag
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \IvaoBrasil\Infrastructure\Models\Academy\Category> $categories
 * @property-read int|null $categories_count
 * @method static \IvaoBrasil\Infrastructure\Factories\Academy\TagFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @mixin \Eloquent
 */
class Tag extends Model
{
    use HasFactory;

    protected $table = "academy_tags";

    protected $fillable = [
        "name", "created_at", "updated_at"
    ];

    protected $visible = [
        "id", "name", "created_at", "updated_at"
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'academy_categories_tags');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory<static>
     */
    protected static function newFactory(): Factory
    {
        return TagFactory::new();
    }
}
