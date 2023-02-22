<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $rafa = User::factory()->create([
            'name' => 'rafael',
            'email' => 'patata@patata.es',
            'password' => Hash::make('patata123'),
        ]);
        $josep = User::factory()->create([
            'name' => 'josep',
            'email' => 'josep@patata.es',
            'password' => Hash::make('patata123'),
        ]);
        $jaume = User::factory()->create([
            'name' => 'jaume',
            'email' => 'jaume@patata.es',
            'password' => Hash::make('patata123'),
        ]);

        $ubuntu = Community::factory()->hasAttached(User::factory(3))->hasAttached([$josep, $rafa])->create([
            'name' => 'Ubuntu',
            'description' => 'Comunidad de usuarios de Ubuntu Linux',
            'rules' => '1. Sé civil<br />2. Sé respetuoso<br />3.Mantente dentro del tema',
        ]);
        $arch = Community::factory()->hasAttached(User::factory(3))->hasAttached($rafa)->create([
            'name' => 'Arch Linux',
            'description' => 'BTW I use Arch',
            'rules' => '1. No distribuciones derivadas.<br/>2. RTFM',
        ]);
        $debian = Community::factory()->hasAttached(User::factory(3))->hasAttached([$jaume, $rafa])->create([
            'name' => 'Debian Linux',
            'description' => 'Red de usuarios de Debian Linux',
            'rules' => 'Trata de ayudar y compartir tus conocimientos con la comunidad',
        ]);

        Post::factory(3)->has(Comment::factory()->for($josep))->create([
            'user_id' => $rafa->id,
            'community_id' => $ubuntu->id,
        ]);
        Post::factory(3)->has(Comment::factory()->for($rafa))->create([
            'user_id' => $josep->id,
            'community_id' => $ubuntu->id,
        ]);
        Post::factory(3)->has(Comment::factory()->for($jaume))->create([
            'user_id' => $rafa->id,
            'community_id' => $arch->id,
        ]);
        Post::factory(3)->has(Comment::factory()->for($rafa))->create([
            'user_id' => $jaume->id,
            'community_id' => $debian->id,
        ]);
    }
}
