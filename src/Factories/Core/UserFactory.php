<?php


namespace IvaoBrasil\Infrastructure\Factories\Core;

use Illuminate\Database\Eloquent\Factories\Factory;
use IvaoBrasil\Infrastructure\Data\User\AtcRating;
use IvaoBrasil\Infrastructure\Data\User\PilotRating;
use IvaoBrasil\Infrastructure\Models\Core\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vid' => $this->faker->numberBetween(100000, 999999),
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'atcRating' => $this->faker->randomElement(AtcRating::class),
            'pilotRating' => $this->faker->randomElement(PilotRating::class),
            'division' => $this->faker->countryCode,
            'country' => $this->faker->countryCode,
            'staff' => []
        ];
    }
}
