<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = 'Categories';
        $categories = Category::latest()->get();
        return view('admin.categories', compact('page', 'categories'));
    }

    public function create()
    {
        $page = 'create category';
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('admin.create-category', \compact('page', 'categories'));
    }
    public function store(Request $request)
    {
        $image = null;
        if ($request->image) {
            $dir = 'storage/settings/categories/';
            $image = $this->uploadFile($request->image, $dir);
        }
        $category = new Category;
        $category->title = $request->title;
        $category->desc = $request->desc;
        $category->image = $image;
        $category->user_id = $request->user_id;

        if ($request->has('parent_id')) {
            $category->parent_id = $request->parent_id;
        }

        $category->save();
        session()->flash('success', 'Category created successfully');
        return redirect()->route('categories.index');
    }
    public function edit($id)
    {
        $page = 'update category';
        $category = Category::find($id);
        $categories = Category::all();
        return view('admin.update-category', \compact('page', 'category', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $image = $category->image;
        $category->fill($request->all());
        if ($request->$image) {
            $dir = 'storage/settings/categories/';
            $image = $this->uploadFile($request->$image, $dir);
            $category->image = $image;
            $category->save();
        }

        if ($request->has('parent_id')) {
            $category->parent_id = $request->parent_id;
        }

        session()->flash('success', 'Category updated successfully');
        return redirect()->route('categories.index');
    }
    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category->posts()->count() > 0) {
            session()->flash('error', 'Category can not be delelted cause it has posts');
            return back();
        }

        $category->delete();
        session()->flash('success', 'Category delelted successfully');
        return back();
    }
}
