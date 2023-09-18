<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\SendEmailNotification;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function sendnotification()
    {
        $user = User::all();
        $details = [
            'greeting' => 'hello greeting',
            'body' => 'this is the message',
            'actiontext' => 'subscribe to my channel',
            'actionurl' => '/',
            'lastline' => 'this is last line',
        ];

        Notification::send($user, new SendEmailNotification($details));
        dd('done');
    }

}
