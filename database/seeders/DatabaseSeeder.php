<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Partials;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
	    $this->call([
			Partials\RoleSeeder::class,
			Partials\UserSeeder::class,
	    ]);
    }
}
