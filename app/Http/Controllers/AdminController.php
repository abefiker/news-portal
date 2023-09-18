<?php

namespace App\Http\Controllers;

use App\Models\Advertise;
use App\Models\Event;
use App\Models\Post;
use App\Models\Setting;
use App\Models\video;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Writer;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{


    public function setLocale($locale)
{
    app()->setLocale($locale);
    return view('master');
}

    public static function welcome()
    {
        $settings = Setting::latest()->first();

        return view('welcome', \compact('settings'));
    }
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

    public static function home()
    {
        $Advertise_requests = Advertise::all();
        $Event = Event::all();
        $Post = Post::all();
        $latest_posts = Post::latest()->take(5)->get();
        $latest_users = User::latest()->take(5)->get();
        $writers = User::where('is_writer', 1)->get();
        $advertise = User::where('is_adverter', 1)->get();
        $video = Video::all();
        $Category = Category::all();
        $User = User::all();
        $Writer_requests = Writer::all();
        return view(
            'admin.home',
            \compact(
                'Advertise_requests',
                'Event',
                'Post',
                'video',
                'Category',
                'User',
                'Writer_requests',
                'latest_posts',
                'writers',
                'latest_users',
                'advertise'
            )
        );
    }

    public function settingsUpdateForm()
    {

        $page = "Update Settings";
        $settings = Setting::latest()->first();
        return view('admin.update-setting', \compact('settings', 'page'));
    }

    public function settingsUpdate(Request $request)
    {
        $logo = null;
        $settings = Setting::latest()->first();
        if ($request->site_logo) {
            $logo = $request->site_logo;
        }
        if ($request->site_logo) {
            $dir = 'storage/settings/logo/';
            $logo = $this->uploadFile($request->site_logo, $dir);
        }
        if ($settings != null) {
            $input = $request->all();
            $settings->fill($input)->save();
            $settings->site_logo = $logo;
            $settings->save();
            session()->flash('success', 'Settings updated successfully');
            return back();
        } else {

            $input = $request->all();
            $input['site_logo'] = $logo; // Add the logo to the input data before creating the new record.
            Setting::create($input);
            session()->flash('success', 'Settings created successfully');
            return back();
        }
    }

    //category cruds methods

    public function categories(Request $request)
    {
        $page = 'Categories';

        if ($request->ajax()) {
            $data = Category::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btns = '<div class="btn-group">
            <a href="' . route('admin.category.update.form', $data->id) . '" class="edit btn btn-primary btn-sm">view/edit</a>
            <a href="' . route('admin.category.destroy', $data->id) . '" class="btn btn-danger btn-sm">Delete</a></div>';
                    return $btns;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.categories', compact('page'));
    }

    public function categoryCreateForm()
    {
        $page = 'create category';
        return view('admin.create-category', \compact('page'));
    }
    public function categoryCreate(Request $request)
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
        $category->save();
        session()->flash('success', 'Category created successfully');
        return redirect()->route('admin.categories');
    }
    public function categoryUpdateForm($id)
    {
        $page = 'update category';
        $category = Category::find($id);
        return view('admin.update-category', \compact('page', 'category'));
    }
    public function categoryUpdate(Request $request, $id)
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
        session()->flash('success', 'Category updated successfully');
        return redirect()->route('admin.categories');
    }
    public function categoryDestroy($id)
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


    //crud for post
    public function posts(Request $request)
    {
        $page = 'posts';
        $posts = Post::latest()->get();
        $trash = 'Trashed Posts';
        $trashedPosts = Post::onlyTrashed()->get();
        return view('admin.posts', compact('page', 'posts', 'trash', 'trashedPosts'));
    }



    public function postCreateForm()
    {
        $page = 'create post';
        $categories = Category::latest()->get();

        return view('admin.create-post', \compact('page', 'categories'));
    }
    public function postCreate(Request $request)
    {
        // $post = new Post;
        // $post->title = $request->title;
        // $post->short_desc = $request->short_desc;
        // $post->long_desc = $request->long_desc;
        // $post->special = $request->special;
        // $post->breaking = $request->breaking;
        // $post->views = $request->views;
        // $post->save();


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
        return redirect()->route('admin.posts');
    }
    public function postUpdateForm($id)
    {
        $page = 'update post';
        $post = Post::with('category')->find($id, ['*']);
        $categories = Category::all(['*']);
        return view('admin.update-post', compact('page', 'post', 'categories'));
    }
    public function postUpdate(Request $request, $id)
    {

        $post = Post::find($id);
        $image = $post->image;
        $post->fill($request->all());
        if ($request->$image) {
            $dir = 'storage/settings/posts/';
            $image = $this->uploadFile($request->$image, $dir);
            $post->image = $image;
            $post->save();
        }
        session()->flash('success', 'Post updated successfully');
        return redirect()->route('admin.posts');
    }

    public function postDestroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        session()->flash('success', 'post deleted successfully');
        return redirect()->route('admin.posts');
    }



    public function postRestore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        session()->flash('success', 'post restored successfully');
        return redirect()->route('admin.posts');
    }

    //crud for events

    public function events()
    {
        $page = 'events';
        $events = Event::latest()->get();
        return view('admin.events', compact('page', 'events'));
    }
    public function eventCreateForm()
    {
        $page = 'create event';
        return view('admin.create-event', \compact('page'));
    }
    public function eventCreate(Request $request)
    {
        Event::create($request->all());
        session()->flash('success', 'Event created successfully');
        return redirect()->route('admin.events');
    }
    public function eventUpdateForm($id)
    {
        $page = 'update event';
        $event = Event::find($id);
        return view('admin.update_event', compact('page', 'event'));
    }
    public function eventUpdate(Request $request, $id)
    {
        $event = Event::find($id);
        $event->fill($request->all());
        $event->save();
        session()->flash('success', 'Event updated successfully');
        return redirect()->route('admin.events');
    }
    public function eventDestroy($id)
    {
        $event = Event::find($id);
        $event->delete();
        session()->flash('success', 'Event deleted successfully');
        return back();
    }

    //writer and adverter
    public function writer_requests()
    {
        $page = 'Writer Request';
        $writer_requests = Writer::latest()->get();
        return view('admin.writer-request', compact('writer_requests', 'page'));
    }
    public function writer_requestsApprove($id)
    {
        $user = User::find($id);
        $user->is_writer = 1;
        $user->save();
        session()->flash('success', 'user role successfully change to writer');
        return back();
    }

    public function writer_requestsDestroy($id)
    {
        $writer = Writer::find($id);
        $writer->delete();
        session()->flash('success', 'Writer request deleted successfully');
        return back();
    }
    public function writer_requestsBann($id)
    {
        $user = User::find($id);
        $user->is_writer = 0;
        $user->save();
        session()->flash('success', 'user successfully ban from writer');
        return back();
    }
    public function adverter_requests()
    {
        $page = 'Adverter Request';
        $adverter_requests = Advertise::latest()->get();
        return view('admin.adverter-request', compact('adverter_requests', 'page'));
    }
    public function adverter_requestsApprove($id)
    {
        $user = User::find($id);
        $user->is_adverter = 1;
        $user->save();
        session()->flash('success', 'user role successfully change to adverter');
        return back();
    }
    public function adverter_requestsDestroy($id)
    {
        $advert = Advertise::find($id);
        $advert->delete();
        session()->flash('success', 'Advertise request deleted successfully');
        return back();
    }
    public function adverter_requestsBann($id)
    {
        $user = User::find($id);
        $user->is_adverter = 0;
        $user->save();
        session()->flash('success', 'user successfully ban from adverter');
        return back();
    }
    public function video()
    {
        $page = 'video';
        $videos = video::latest()->get();
        if (auth()->user()->is_writer) {
            $videos = video::where('user_id', auth()->id())->latest()->get();
        }

        return view('admin.video', compact('page', 'videos'));
    }

    public function videoCreateForm()
    {
        $page = 'create video';
        $categories = Category::latest()->get();
        return view('admin.create-video', \compact('page', 'categories'));
    }
    public function videoCreate(Request $request)
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
            return redirect()->route('admin.video');
        } else {
            // Handle the case where no user is authenticated
            // You might want to redirect to a login page or take appropriate action
        }
    }

    public function videoUpdateForm($id)
    {
        $page = 'update video';
        $video = video::find($id);
        $categories = Category::latest()->get();
        return view('admin.update-video', compact('page', 'video', 'categories'));
    }
    public function videoUpdate(Request $request, $id)
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
        return redirect()->route('admin.video');
    }
    public function videoDestroy($id)
    {
        $video = video::find($id);
        $video->delete();
        session()->flash('success', 'Video deleted successfully');
        return back();
    }
    public function users(Request $request)
    {
        $page = 'Registered Users';

        if ($request->ajax()) {
            $data = User::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btns = '<div class="btn-group">
            <a href="' . route('admin.user.update.form', $data->id) . '" class="edit btn btn-primary btn-sm">view/edit</a>
            <a href="' . route('admin.user.destroy', $data->id) . '" class="btn btn-danger btn-sm">Delete</a></div>';
                    return $btns;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.users', compact('page'));
    }
    public function UpdateUserForm($id)
    {
        $user = User::find($id);
        return view('admin.profile', \compact('user'));
    }
    public function UpdateUserImage(Request $request, $id)
    {
        $user = User::find($id);
        if (!$request->image) {
            session()->flash('error', 'image field if requered');
            return back();
        }
        if ($request->image) {
            $dir = 'storage/settings/profile/';
            $new_image = $this->uploadFile($request->image, $dir);
            $user->image = $new_image;
            $user->save();
        }
        session()->flash('success', 'user image updated successfully');
        return back();
    }
    public function UpdateUser(Request $request, $id)
    {
        $user = User::find($id);
        $input = $request->all();
        $user->fill($input)->save();

        if ($request->password) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
        }

        session()->flash('success', 'user detail updated successfully');
        return back();
        ;
    }
    public function DestroyUser($id)
    {
        $user = User::find($id);
        $user->delete();
        session()->flash('success', 'user deleted successfully');
        return back();
    }
    public function writers()
    {

    }
}
