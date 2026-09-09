<?php

namespace App\Http\Controllers;

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

        try {
            DB::connection()->getPdo();
            echo "Conexão com o banco de dados estabelecida com sucesso.";
        } catch (\PDOException $e) {
            echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
        }
    
        // echo "Username: $username <br>";
    }   

    public function logout()
    {
        echo "Logout";
    }
}
