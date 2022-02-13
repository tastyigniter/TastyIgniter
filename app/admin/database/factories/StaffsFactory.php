<?php

namespace Admin\Database\Factories;

use Admin\Models\Staffs_model;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffsFactory extends Factory
{
    protected $model = Staffs_model::class;

    public function definition(): array
    {
        return [
            'staff_name' => $this->faker->text(32),
            'staff_email' => $this->faker->email,
            'staff_status' => true,
        ];
    }
}
