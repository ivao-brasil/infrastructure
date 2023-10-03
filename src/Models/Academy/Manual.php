<?php
namespace IvaoBrasil\Infrastructure\Models\Academy;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use IvaoBrasil\Infrastructure\Factories\Academy\ManualFactory;

/**
 * IvaoBrasil\Infrastructure\Models\Academy\Manual
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \IvaoBrasil\Infrastructure\Models\Academy\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \IvaoBrasil\Infrastructure\Models\Academy\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \IvaoBrasil\Infrastructure\Factories\Academy\ManualFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Manual newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Manual newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Manual query()
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $language
 * @property string $file_path
 * @property int $is_visible
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Manual whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manual whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manual whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manual whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manual whereIsVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manual whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manual whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manual whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Manual extends Model
{
    use HasFactory;

    protected $table = "academy_manuals";

    protected $fillable = [
        "title", "description", "language", "file_path", "is_visible", "created_at", "updated_at"
    ];

    protected $visible = [
        "id", "title", "description", "language", "file_path", "is_visible", "tags", "categories", "created_at", "updated_at"
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'academy_manuals_tags');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'academy_manuals_categories');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory<static>
     */
    protected static function newFactory(): Factory
    {
        return ManualFactory::new();
    }
}
