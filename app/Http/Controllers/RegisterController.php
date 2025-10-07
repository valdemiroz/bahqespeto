<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Exibe o formulário de cadastro.
     */
    public function create()
    {
        return view('cadastro'); // aponta para resources/views/cadastro.blade.php
    }

    /**
     * Registra o novo usuário.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|max:255|unique:users,email',
            'senha' => 'required|min:6|confirmed',
        ]);

        // Cria o usuário
        $user = Usuario::create([
            'usuario' => $request->usuario,
            'email' => $request->email,
            'senha' => Hash::make($request->senha),
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
        ]);

        // Faz login automático após cadastrar
        auth()->login($user);

        // Redireciona ao painel do usuário
        return redirect()->route('usuario')->with('success', 'Conta criada com sucesso!');
    }
}
