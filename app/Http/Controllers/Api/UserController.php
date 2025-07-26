<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);
        return new UserResource(true, 'List Data User', $users);
    }
    public function store(Request $request)
    {
        //define validaƟon rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        //check if validaƟon fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        //return response
        return new UserResource(true, 'Data User Berhasil Ditambahkan!', $user);
    }
    public function show($id)
    {
        //find user by ID
        $user = User::find($id);
        //return single user as a resource
        return new UserResource(true, 'Detail Data User !', $user);
    }
    public function update(Request $request, $id)
    {
        //define validaƟon rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        //check if validaƟon fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //find user by ID
        $user = User::find($id);
        //update user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        //return response
        return new UserResource(true, 'Data Product Berhasil Diubah!', $user);
    }
    public function destroy($id)
    {
        //find user by ID
        $user = User::find($id);
        //delete user
        $user->delete();
        //return response
        return new UserResource(true, 'Data User Berhasil Dihapus!', null);
    }

    public function detail(Request $request)
    {
        return $request->user();
    }
    public function uploadFoto(Request $request)
    {
        $user = Auth::user();
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->store('public/foto');
            $user->foto = basename($path);

            $user->save();
        }
        return $user;
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['message' => 'Password updated']);
    }
}