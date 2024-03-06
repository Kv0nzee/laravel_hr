<?php

// DepartmentFactory.php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

