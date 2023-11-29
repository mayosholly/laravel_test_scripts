<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testCreatePost()
    {
        // $data = [
        //     'title' => 'Test Post',
        //     'content' => 'This is a test post content.',
        // ];
        $data = Post::factory()->make();

        $response = $this->json('POST', '/api/posts', $data->toArray());

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', $data->toArray());
    }

    public function testGetAllPosts()
    {
        Post::factory(3)->create();

        $response = $this->json('GET', '/api/posts');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function testGetSinglePost()
    {
        $post = Post::factory()->create();

        $response = $this->json('GET', '/api/posts/' . $post->id);

        $response->assertStatus(200)
            ->assertJson([
                'title' => $post->title,
                'content' => $post->content,
            ]);
    }

    public function testDeletePost()
    {
        $post = Post::factory()->create();

        $response = $this->json('DELETE', '/api/posts/' . $post->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    
    

}
