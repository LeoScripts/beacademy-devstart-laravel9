<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;

class PostController extends Controller
{
    protected $user;
    protected $post;

    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    public function index()
    {
        // dd($this-user->find($userId));
        // if(!$user = $this->user->find($userId)){
        //     return redirect()->back();
        // }

        // $posts = $user->posts()->get();
        $posts = $this->post->all();

        return view('posts.index', compact( 'posts'));
    }
}
