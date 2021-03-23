<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $directory  = storage_path('app\public\uploads\images\clients');
        if(!Storage::exists($directory)){
            Storage::makeDirectory($directory);
        }
        return [
            'username' => $this->faker->userName,
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'password' => bcrypt('123123'),
            'age' => $this->faker->numberBetween(10,85),
            'biography' => $this->faker->text,
            'img' => $this->faker->image($directory,256,256)
        ];
    }
}
