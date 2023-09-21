<?php

namespace App\Http\Controllers;

use App\Models\Advertise;
use App\Models\Category;
use App\Models\Event;
use App\Models\Post;
use App\Models\Setting;
use App\Models\video;
use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class FrontendController extends Controller
{
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

    public function welcome()
    {
        $categories = Category::latest()->get();
        $settings = Setting::latest()->first();
        $videos = video::latest()->get();
        $latest_videos = video::latest()->take(5)->get();
        $latest_breaking_news = Post::where('breaking', 1)->latest()->first();
        $breaking_news = Post::where('breaking', 1)->latest()->get();
        $latest_news = Post::latest()->take(3)->get();
        return view('welcome', \compact('categories', 'settings', 'latest_breaking_news', 'breaking_news', 'latest_news','videos','latest_videos'));
    }
    public function ckupload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'upload' => ['required', 'image', Rule::dimensions()->maxWidth(2000)->maxHeight(2000)],
        ]);

        $uploadedImage = $request->file('upload');

        // Generate a unique file name
        $fileName = Str::random(20) . '.' . $uploadedImage->getClientOriginalExtension();

        // Store the uploaded image in the specified directory
        $path = $uploadedImage->storeAs('uploads', $fileName, 'public');

        // Generate the URL for the uploaded image
        $url = asset('storage/' . $path);

        // Return CKEditor-compatible response
        return response()->json([
            'url' => $url,
        ]);
    }
    public function post($id)
    {
        $post = Post::find($id);
        $post->increment('views',1);
        $settings = Setting::latest()->first();
        return view('client.post', \compact('post', 'settings'));
    }
    public function category($id)
    {
        $category = Category::find($id);
        $title = $category->title;
        $settings = Setting::latest()->first();
        $latest_news = $category->posts()->latest()->take(5)->get();
        $all_news = $category->posts()->paginate(10);
        $trending = $category->posts()->orderBy('views','desc')->take(5)->get();
        return view('client.category', \compact('category', 'settings', 'latest_news', 'all_news', 'title','trending'));
    }


    public function writeForm()
    {
        $user = auth()->user();
        return view('client.become-writer', \compact('user'));
    }
    public function writeForUs(Request $request)
    {
        // Check if a request has already been sent by the authenticated user
        $request_sent = Writer::where('user_id', auth()->id())->first();

        if ($request_sent) {
            // If a request has already been sent, display an error message
            session()->flash('error', 'Request already sent, please wait for admin approval');
        } else {
            // If no request has been sent, create a new request
            Writer::create($request->all());
            // Set a session variable for success message
            session()->flash('success', 'Request saved successfully, we will call you for more information');
        }

        return back();
    }


    public function contactForm()
    {

    }
    public function contactUs()
    {

    }
    public function advertiseForm()
    {
        $user = auth()->user();
        return view('client.advertise', \compact('user'));
    }
    public function advertise(Request $request)
    {
        $request_sent = Advertise::where('user_id', auth()->id())->first();
        if ($request_sent) {
            // If a request has already been sent, display an error message
            session()->flash('error', 'Request already sent, please wait for admin approval');
        } else {
            // If no request has been sent, create a new request
            Advertise::create($request->all());

            // Set a session variable for success message
            session()->flash('success', 'Request saved successfully, we will call you for more information');
        }

        return back();
    }
    public function about()
    {
        $about = Setting::latest()->first();
        return view('client.about',\compact('about'));
    }
    public function clientEvents()
    {
        $events = Event::latest()->paginate(10);
        return view('client.event' , \compact('events'));
    }
}
