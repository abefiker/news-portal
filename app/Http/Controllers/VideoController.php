<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function uploadFile($image, $dir)
    {
        if (!$image || !$image->isValid()) {
            // Handle the case when no file is uploaded or the file is not valid
            return null;
        }

        $image_name = $image->getClientOriginalName();
        $new_image = time() . $image_name;
        $image->move($dir, $new_image);

        return $new_image;
    }
    public function index()
    {
        $page = 'video';
        $videos = video::latest()->get();
        if (auth()->user()->is_writer) {
            $videos = video::where('user_id', auth()->id())->latest()->get();
        }

        return view('admin.video', compact('page', 'videos'));
    }

    public function create()
    {
        $page = 'create video';
        $categories = Category::latest()->get();
        return view('admin.create-video', \compact('page', 'categories'));
    }
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'url' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Adjust as needed
        ]);

        // Check if the user is authenticated
        if (auth()->check()) {
            // Process the uploaded file and move it to the storage directory.
            $image = null;
            if ($request->hasFile('image')) {
                $dir = 'storage/settings/videos/';
                $image = $this->uploadFile($request->file('image'), $dir);
            }

            // Retrieve the user's ID
            $user_id = auth()->user()->id;

            // Create the video record
            $video = new Video;
            $video->title = $request->title;
            $video->url = $request->url;
            $video->image = $image;
            $video->category_id = $request->category_id;
            $video->user_id = $user_id;
            $video->save();

            session()->flash('success', 'Video created successfully');
            return redirect()->route('videos.index');
        } else {
            // Handle the case where no user is authenticated
            // You might want to redirect to a login page or take appropriate action
        }
    }

    public function edit($id)
    {
        $page = 'update video';
        $video = video::find($id);
        $categories = Category::latest()->get();
        return view('admin.update-video', compact('page', 'video', 'categories'));
    }
    public function update(Request $request, $id)
    {

        $video = video::find($id);
        $image = $video->image;
        $video->fill($request->all());
        if ($request->$image) {
            $dir = 'storage/settings/videos/';
            $image = $this->uploadFile($request->$image, $dir);
            $video->image = $image;
            $video->save();
        }
        session()->flash('success', 'Video updated successfully');
        return redirect()->route('videos,index');
    }
    public function destroy($id)
    {
        $video = video::find($id);
        $video->delete();
        session()->flash('success', 'Video deleted successfully');
        return back();
    }
}
