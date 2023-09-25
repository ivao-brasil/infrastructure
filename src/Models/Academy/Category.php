<?php
namespace IvaoBrasil\Infrastructure\Models\Academy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\Factory;
use IvaoBrasil\Infrastructure\Factories\Academy\CategoryFactory;

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
