<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        DB::statement("TRUNCATE TABLE cars");
        return [

            'plaque_number' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now()

        ];
    }
}
