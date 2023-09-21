<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = 'Registered Users';

        if ($request->ajax()) {
            $data = User::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btns = '<div class="btn-group">
            <a href="' . route('users.edit', $data->id) . '" class="edit btn btn-primary btn-sm">view/edit</a>
            <a href="' . route('users.destroy', $data->id) . '" class="btn btn-danger btn-sm">Delete</a></div>';
                    return $btns;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.users', compact('page'));
    }
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.profile', \compact('user'));
    }
    public function update(Request $request, $id)
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
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        session()->flash('success', 'user deleted successfully');
        return back();
    }
}
