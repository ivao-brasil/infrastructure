<?php

namespace IvaoBrasil\Infrastructure\Factories\SupportAward;

use Illuminate\Database\Eloquent\Factories\Factory;
use IvaoBrasil\Infrastructure\Models\SupportAward\Report;
use IvaoBrasil\Infrastructure\Models\Core\User;
use IvaoBrasil\Infrastructure\Models\TrainingSchedule\TrainingSession;

class ReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "connectionType" => "PILOT",
            "callsign" => $this->faker->text(8),
            "status" => $this->faker->randomElement(["VALIDATING", "REJECTED", "APPROVED"]),
            "owner_vid" => User::factory(),
            "session_id" => TrainingSession::factory()
        ];
    }
}
