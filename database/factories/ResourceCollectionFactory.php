<?php

namespace Database\Factories;

use App\Models\ResourceCollection;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ResourceCollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResourceCollection::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $title = $this->faker->words(3, true);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->sentence(),
            'user_id' => User::factory(),
        ];
    }
}
