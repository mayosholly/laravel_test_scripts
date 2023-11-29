<?php

namespace Tests\Unit;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Tests\TestCase;


class PostRepositoryTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_create(){
        $repository = new PostRepository();
        $postData = [
            'title' => 'new',
            'content' => 'Hello everyone',
        ];
        $result = $repository->createPost($postData);
        $this->assertSame('new', $result->title, 'They matched');
    }

    public function test_update()
    {
        // goal
        $repository = $this->app->make(PostRepository::class);
        // env
        // data and source of truth
        $post = Post::factory(1)->create()->toArray();
        $payload = [
            'title' => 'new'
        ];
        // compare
        $updated = $repository->updatePost($post[0]['id'], $payload);
        $this->assertSame($payload['title'], $updated->title, 'They matched');
    }

    public function test_delete()
    {
        $repository = $this->app->make(PostRepository::class);
        $dummy = Post::factory(1)->create()->first();
        $deleted = $repository->deletePost($dummy->id);
        // $deleted->assertStatus(204);


        // $this->assertDatabaseMissing('posts', ['id' => $deleted->id], 'Post not found');
        // $found = Post::query()->findOrFail($deleted->id);
        // $this->assertSame(null, $found, 'Post is not deleted');
    }
}
