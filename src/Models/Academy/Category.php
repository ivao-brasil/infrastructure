<?php
namespace IvaoBrasil\Infrastructure\Models\Academy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\Factory;
use IvaoBrasil\Infrastructure\Factories\Academy\CategoryFactory;

/**
 * IvaoBrasil\Infrastructure\Models\Academy\Category
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \IvaoBrasil\Infrastructure\Models\Academy\Manual> $manuals
 * @property-read int|null $manuals_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \IvaoBrasil\Infrastructure\Models\Academy\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \IvaoBrasil\Infrastructure\Factories\Academy\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;

    protected $table = "academy_categories";

    protected $fillable = [
        "name", "created_at", "updated_at"
    ];

    protected $visible = [
        "id", "name", "tags", "manuals", "created_at", "updated_at"
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'academy_categories_tags');
    }

    public function manuals(): BelongsToMany
    {
        return $this->belongsToMany(Manual::class, 'academy_manuals_categories');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory<static>
     */
    protected static function newFactory(): Factory
    {
        return CategoryFactory::new();
    }
}
