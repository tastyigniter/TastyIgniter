<?php

namespace Admin\Database\Factories;

use Admin\Models\Staffs_model;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    protected $model = Staffs_model::class;

    public function definition(): array
    {
        return [
            'staff_name' => $this->faker->name,
            'staff_email' => $this->faker->email,
            'staff_status' => TRUE,
        ];
    }
}
