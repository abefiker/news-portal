<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Writer;
use Illuminate\Http\Request;

class WriterController extends Controller
{
    public function index()
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

    public function destroy($id)
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
}
