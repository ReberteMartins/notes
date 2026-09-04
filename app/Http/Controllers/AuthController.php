<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        // form validation
        $request->validate([
            'text_username' => 'required|email',
            'text_password' => 'required|min:6',
        ]);

        $username = $request->input('text_username');
        $password = $request->input('text_password');
    
        echo "Username: $username <br>";
    }   

    public function logout()
    {
        echo "Logout";
    }
}
