<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'rafael',
            'email' => 'patata@patata.es',
            'password' => Hash::make('patata123'),
        ]);
        User::factory()->create([
            'name' => 'josep',
            'email' => 'josep@patata.es',
            'password' => Hash::make('patata123'),
        ]);
        User::factory()->create([
            'name' => 'jaume',
            'email' => 'jaume@patata.es',
            'password' => Hash::make('patata123'),
        ]);
    }
}
