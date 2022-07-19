<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrganizationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $regions = get_regions(['CA'], config('app.locale'));
        $name = $this->faker->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'locality' => $this->faker->city(),
            'region' => $regions[$this->faker->numberBetween(0, 12)]['value'],
        ];
    }
}
