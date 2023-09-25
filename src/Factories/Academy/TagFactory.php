<?php


namespace IvaoBrasil\Infrastructure\Factories\Academy;


use Illuminate\Database\Eloquent\Factories\Factory;
use IvaoBrasil\Infrastructure\Models\Academy\Tag;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

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
