<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = 'posts';
        $posts = Post::latest()->get();
        $trash = 'Trashed Posts';
        $trashedPosts = Post::onlyTrashed()->get();
        return view('admin.posts', compact('page', 'posts', 'trash', 'trashedPosts'));
    }


    public function create()
    {
        $page = 'create post';
        $categories = Category::latest()->get();

        return view('admin.create-post', \compact('page', 'categories'));
    }
    public function store(Request $request)
    {
        $image = null;
        if ($request->image) {
            $dir = 'storage/settings/posts/';
            $image = $this->uploadFile($request->image, $dir);
        }
        $post = new Post;
        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->user_id = auth()->user()->id;
        $post->short_desc = $request->short_desc;
        $post->long_desc = $request->long_desc;
        $post->special = $request->special;
        $post->image = $image;
        $post->breaking = $request->breaking;
        $post->views = 0;
        $post->save();
        session()->flash('success', 'Post created successfully');
        return redirect()->route('posts.index');
    }
    public function show($id)
    {
        $page = 'update post';
        $post = Post::with('category')->find($id, ['*']);
        $categories = Category::all(['*']);
        return view('admin.update-post', compact('page', 'post', 'categories'));
    }
    public function edit($id)
    {
        $page = 'update Post';
        $post = Post::with('category')->find($id);
        $categories = Category::all(['*']);
        return view('admin.update-post', compact('page', 'post', 'categories'));
    }

    public function update(Request $request, $id)
    {

        $post = Post::find($id);
        $image = $post->image;
        $post->fill($request->all());
        if ($request->hasFile('image')) {
            $dir = 'storage/settings/posts/';
            $image = $this->uploadFile($request->file('image'), $dir);
            $post->image = $image;
        }
        $post->save();
        session()->flash('success', 'Post updated successfully');
        return redirect()->route('posts.index');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post) {
            $post->delete();
            session()->flash('success', 'post deleted successfully');
        } else {
            session()->flash('error', 'Post not found');
        }
        return redirect()->route('posts.index');
    }



    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        session()->flash('success', 'post restored successfully');
        return redirect()->route('posts.index');
    }
}
