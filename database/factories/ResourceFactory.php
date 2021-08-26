<?php

namespace Database\Factories;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->words(5, true);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'language' => config('app.locale'),
            'summary' => $this->faker->paragraphs(3),
            'user_id' => User::factory(),
        ];
    }
}
