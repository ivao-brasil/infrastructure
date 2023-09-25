<?php


namespace IvaoBrasil\Infrastructure\Models\Academy;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use IvaoBrasil\Infrastructure\Factories\Academy\TagFactory;

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
