<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommunityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * @test
     *
     * @return void
     */
    public function can_fetch_single_community()
    {
        $this->withoutExceptionHandling();
        $community = Community::factory()->create();
        $response = $this->getJson('/api/communities/1');
        $response->assertStatus(200);
        $response->assertHeader(
            'Content-Type', 'application/json'
        );
        $response
        ->assertJson([
            'data' => [
                'id' => $community->id,
                'name' => $community->name,
                'description' => $community->description,
                'rules' => $community->rules,
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_can_fetch_all_communities()
    {
        $communities = Community::factory(3)->create();

        $response = $this->getJson('/api/communities');

        $response->assertStatus(200);
        foreach ($communities as $community)
        {
            $response
                ->assertJson(fn(AssertableJson $json) =>
                    $json->has('data', 3)
                    ->etc()
            );
        }
    }

    /**
     * @test
     * 
     * @return void
     */
    public function can_fetch_all_communities()
    {
        $this->withoutExceptionHandling();

        $communities = Community::factory(3)->create();

        $response = $this->getJson('/api/communities');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                [
                    'id' => $communities[0]->id,
                    'name' => $communities[0]->name,
                    'description' => $communities[0]->description,
                    'rules' => $communities[0]->rules,
                ],
                [
                    'id' => $communities[1]->id,
                    'name' => $communities[1]->name,
                    'description' => $communities[1]->description,
                    'rules' => $communities[1]->rules,
                ],
                [
                    'id' => $communities[2]->id,
                    'name' => $communities[2]->name,
                    'description' => $communities[2]->description,
                    'rules' => $communities[2]->rules,
                ],
            ]
        ]);
    }

    /**
     * @test
     */
    public function can_create_community()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/communities', [
            'name' => 'Test Community',
            'description' => 'Testing, one, two, three.',
            'rules' => 'One, two, three.'
        ], [
            'Content-Type' => 'application/api+json'
        ]);

        $response->assertCreated();

        $community = Community::first();

        $response->assertHeader(
            'Content-Type', 'application/json'
        );

        $response->assertJson([
            'data' => [
                'id' => (string)$community->getRouteKey(),
                'name' => 'Test Community',
                'description' => 'Testing, one, two, three.',
                'rules' => 'One, two, three.'
            ]
        ]);
    }

    /**
     * @test
     */
    public function guests_cannot_create_community()
    {
        $this->postJson('/api/communities', [], [
            'Content-Type' => 'application/json'
        ])->assertStatus(401);
    }

    /**
     * @test
     */
    public function name_is_required()
    {
        $response = $this->postJson('/api/communitites',
        [
            'description' => 'abc',
            'rules' => 'bcd',
        ],
        [
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(405);
    }

    /**
     * @test
     */
    public function can_update_community()
    {
        $this->withoutExceptionHandling();
        $community = Community::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->putJson("api/communities/$community->id",
        ['name' => 'Debian']);
        $response->assertStatus(200);
        $response->assertJsonFragment(
            ['name' => 'Debian']
        );
    }

    /**
     * @test
     */
    public function can_return_a_json_api_error_object_when_a_community_is_not_found()
    {
        $response = $this->getJson('/api/communities/1234');
        $response->assertStatus(404);
        $response->assertJson([
            'error' => 'not found',
        ]);
    }

      /**
     * @test
     */
    public function can_delete_community()
    {
        $this->withoutExceptionHandling();
        $community = Community::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->deleteJson("api/communities/$community->id")
        ->assertNoContent();
        $this->assertSoftDeleted($community);
    }
}
