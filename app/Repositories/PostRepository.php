<?php
namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    /**
     * Create a new user
     * 
     * @param array $data
     * @return User
     */
    public function createPost(array $data)
    {
        $post = Post::create($data);
        return $post;
    }

    public function updatePost($id, array $data)
    {
        $post = Post::findOrfail($id);
        $post->update($data);
        return $post;
    }

    public function deletePost($id)
    {
        $post = Post::findOrfail($id);
        $post->delete();
    }
}