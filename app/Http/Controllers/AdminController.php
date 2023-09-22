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



    //crud for events



    //writer and adverter
   
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
    public function writers()
    {

    }
}
