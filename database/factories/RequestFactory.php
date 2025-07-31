<?php

namespace Database\Factories;

use App\Models\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestFactory extends Factory
{
    protected $model = Request::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'requested_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
