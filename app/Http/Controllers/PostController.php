<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
       /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * UserController constructor
     * @param PostRepository $userRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = $this->postRepository->createPost($request->all());
        return response()->json($post, 201);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = $this->postRepository->updatePost($id, $request->all());
        return response()->json($post, 200);
    }

    public function destroy($id)
    {
        $this->postRepository->deletePost($id);
        return response()->json(null, 204);
    }
}
