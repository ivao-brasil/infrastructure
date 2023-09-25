<?php


namespace IvaoBrasil\Infrastructure\Factories\Academy;


use Illuminate\Database\Eloquent\Factories\Factory;
use IvaoBrasil\Infrastructure\Models\Academy\Category;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->unique()->word,
        ];
    }
}
