<?php

namespace Database\Factories;

use Alirezasedghi\LaravelImageFaker\ImageFaker;
use App\Models\User;
use Database\Fakers\Images\ThisPersonDoesNotExist;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Lottery;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function configure(): Factory|UserFactory
    {
        return $this->afterCreating(function (User $user) {
            Lottery::odds(4,5)->winner(fn () => $user
                ->addMediaFromUrl(
                    (new ImageFaker(new ThisPersonDoesNotExist))->imageUrl()
                )
                ->usingName($name = Str::random(40))
                ->sanitizingFileName(
                    fn (string $filename) => Str::replace(pathinfo($filename, PATHINFO_FILENAME), $name, $filename)
                )
                ->toMediaCollection('avatar')
            )->choose();
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
