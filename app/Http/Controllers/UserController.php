<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        //$users = \App\Models\User::paginate(10);
        $users = DB::table('users')->orderBy('id', 'desc')->get();
        return view('pages.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User successfully deleted');
    }

    public function create()
    {
        return view('pages.users.create');
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => $request->roles
        ]);

        return redirect()->route('user.index')->with('success', 'User successfully created');
    }

    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('pages.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if($request->password != ''){
            DB::table('users')->where('id',$id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'roles' => $request->roles
            ]);
        }else{
            DB::table('users')->where('id',$id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'roles' => $request->roles
            ]);
        }

        return redirect()->route('user.index')->with('success', 'User successfully updated');
    }
}
