<?php

namespace Database\Seeders;

use Database\Factories\UserCarsFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $this->call(UserTableSeeder::class);
        $this->call(CarTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
