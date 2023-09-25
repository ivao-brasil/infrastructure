<?php
namespace IvaoBrasil\Infrastructure\Models\Academy;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use IvaoBrasil\Infrastructure\Factories\Academy\ManualFactory;

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
