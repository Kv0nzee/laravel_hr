<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role as ModelsRole;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => $this->faker->unique()->randomNumber(),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('12345678'), // Change 'password' to comply with validation
            'pin_code' => Hash::make('12345678'), // Change 'password' to comply with validation
            'phone' => $this->faker->numerify('###########'), // Generate a random 11-digit number
            'nrc_number' => $this->faker->unique()->numerify('#########'), // Generate a unique 9-digit number
            'birthday' => $this->faker->date,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'address' => $this->faker->address,
            'department_id' => Department::inRandomOrder()->first()->id, // Assuming Department model is available
            'is_present' => $this->faker->randomElement(['Yes', 'No']),
            'date_of_join' => $this->faker->date,
        ];
    }

    /**
     * After creating the user, assign a default role.
     */
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $defaultRole = ModelsRole::where('name', 'User')->first();
            $user->syncRoles($defaultRole);
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
