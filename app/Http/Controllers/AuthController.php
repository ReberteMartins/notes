<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $request->validate(
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6',
            ],
            [
                'required' => 'O campo :attribute é obrigatório.',
                'email' => 'O campo :attribute deve ser um email válido.',
                'min' => 'O campo :attribute deve ter no mínimo :min caracteres.',
            ]);

        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // pagar todos os usuario da base de dados
        $user = User::where('username', $username)
                        ->where('deleted_at', null)
                        ->first();
        
        if (!$user) {
            return redirect()
                    ->back()
                    ->withErrors(['text_username' => 'Usuário não encontrado.']);
        }
        if (!password_verify($password, $user->password)) {
            return redirect()
                    ->back()
                    ->withErrors(['text_password' => 'Senha incorreta.']);
        }

        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        session(['user_id' => $user->id, 'username' => $user->username]);

        return redirect()->to('/');
    }   

    public function logout()
    {
        session()->forget(['user_id', 'username']);
        return redirect('/login');
    }
}
