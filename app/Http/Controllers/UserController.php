<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user ()
    {
        $data_user = user::all();
        return view ('User.user' , compact('data_user'));
    }
    public function tambahuser(Request $request)
    {
        return view('User.tambahuser');
    }
    public function insertuser(Request $request)
    {
        user::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>bcrypt($request->password)
        ]);
        return redirect('user');
    }
    public function deleteuser(Request $request, $email)
    {
        $data_user = user::where('email', $email);
        $data_user->delete();
        return redirect ('user');
    }
    
}
