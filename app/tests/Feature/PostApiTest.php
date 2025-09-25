<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;
class PostApiTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    public function it_creates_a_post()
    {
        $payload = ['title' => 'Demo Post', 'body' => 'Text'];
        $res = $this->postJson('/api/posts', $payload);

        $res->assertCreated() // 201
            ->assertJsonFragment(['title' => 'Demo Post']);
        $this->assertDatabaseHas('posts', ['title' => 'Demo Post']);
    }


    /**@test */
    public function it_requires_title_when_creating(){

        $res = $this->postJson('/api/posts',['title' => '']);
        $res->assertStatus(422);
    }

    public function test_it_lists_post(){
        Post::factory()->count(2)->create(['title' => 'A']);
        $response = $this->getJson('/api/posts');
        $response->assertOk()->assertJsonFragment(['title' => 'A']);
    }
}
