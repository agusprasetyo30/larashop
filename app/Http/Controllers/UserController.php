<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::paginate(5);

        // Mengambil data pada input text, jika tidak ada maka bernilai null
        $filterKeyword = $request->get('keyword');
        $status = $request->get('status');


        if ($filterKeyword)
        {
            if ($status)
            {
                $users = User::where("email", "LIKE", "%$filterKeyword%")
                ->where("status", $status)
                ->paginate(5);
            } else {
                $users = User::where("email", "LIKE", "%$filterKeyword%")
                ->paginate(5);
            }
        } else if ($status) {
            $users = User::where("status", "=" , $status)
            ->paginate(5);
        }

        return view('users.index', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            "name"     => "required|min:5|max:100",
            "username" => "required|min:5|max:20",
            "roles"    => "required",
            "phone"    => "required|digits_between:10, 12",
            "address"  => "required|min:20|max:200",
            "avatar"   => "required",
            "email"    => "required|email",
            "password" => "required",
            "password_confirmation" => "required|same:password"
        ])->validate();

        $dataRoles = $request->get('roles');

        $new_user = new User;
        $new_user->name = $request->get('name');
        $new_user->username = $request->get('username');
        $new_user->phone = $request->get('phone');
        $new_user->address = $request->get('address');
        $new_user->email = $request->get('email');
        $new_user->password = Hash::make($request->get('password'));

        if($request->file('avatar'))
        {
            // Upload foto dengan helper
            $file = savePhoto($request->get('name'), $request->file('avatar'), 'avatars');
            $new_user->avatar = $file;
        } else {
            $new_user->avatar = "";
        }

        $new_user->save();

        $new_user->assignRole($dataRoles);

        return redirect()
        ->route('users.create')
        ->with('status', 'User successfully created');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi
        Validator::make($request->all(), [
            "name" => "required|min:5|max:100",
            "roles" => "required",
            "phone" => "required|digits_between:10,12",
            "address" => "required|min:20|max:200",
        ])->validate();

        $dataRoles = $request->get('roles');

        $user = User::findOrFail($id);

        $user->name = $request->get('name');
        $user->address = $request->get('address');
        $user->phone = $request->get('phone');
        $user->status = $request->get('status');

        // dd($request->get('roles'), json_encode($request->get('roles')));

        if ($request->file('avatar'))
        {
            if($user->avatar && file_exists(storage_path('app/public/' . $user->avatar)))
            {
                Storage::delete('public/' . $user->avatar);
            }

            $file = savePhoto($request->get('name'), $request->file('avatar'), 'avatars');

            $user->avatar = $file;
        }

        $user->save();

        $user->syncRoles($dataRoles);

        return redirect()
        ->route('users.edit', ['id' => $id])
        ->with('status','User succesfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->avatar != "")
        {
            Storage::delete('public/' . $user->avatar);
        }

        $user->delete();

        return redirect()
        ->route('users.index')
        ->with('status', 'User successfully delete');

    }
}
