<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Community::factory()->create([
            'name' => 'Ubuntu',
            'description' => 'Comunidad de usuarios de Ubuntu Linux',
            'rules' => '1. Sé civil<br />2. Sé respetuoso<br />3.Mantente dentro del tema',
        ]);
        Community::factory()->create([
            'name' => 'Arch Linux',
            'description' => 'BTW I use Arch',
            'rules' => '1. No distribuciones derivadas.<br/>2. RTFM',
        ]);
        Community::factory()->create([
            'name' => 'Debian Linux',
            'description' => 'Red de usuarios de Debian Linux',
            'rules' => 'Trata de ayudar y compartir tus conocimientos con la comunidad',
        ]);
        Community::factory(3)->hasAttached(User::factory())->create();
    }
}
