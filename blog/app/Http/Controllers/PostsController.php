<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post; 

class PostsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('admin.posts');
    }

    public function showAdd(){
        $categories = Category::all(); 
        return view('admin.post_add')
            ->with('categories', $categories); 
    }

   

    public function indexPosts(){
        $posts = Post::all();
        return view('admin.posts')->with('posts', $posts);
    }
}
