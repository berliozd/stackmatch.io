<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TechSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Tech::factory(10)->create();
    }
}
