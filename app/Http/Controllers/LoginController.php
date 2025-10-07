<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
public function showLoginForm()
{
    return view('login'); // aponta para seu login.blade.php
}
    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'senha'   => 'required|string',
        ]);

        $usuarioValor = $request->input('usuario');
        $senhaValor = $request->input('senha');

        // busca usuário pela coluna 'usuario'
        $user = Usuario::where('usuario', $usuarioValor)->first();

        if (!$user) {
            return back()->withErrors(['usuario' => 'Usuário ou senha incorretos'])->withInput();
        }

        // compara senha: Hash::check (assume senhas hasheadas)
        if (!Hash::check($senhaValor, $user->getAuthPassword())) {
            return back()->withErrors(['usuario' => 'Usuário ou senha incorretos'])->withInput();
        }

        // Se veio do botão admin, verifica se o usuário é admin
        if ($request->query('admin') == 1 && $user->is_admin != 1) {
            return back()->withErrors(['usuario' => 'Somente administradores podem acessar.'])->withInput();
        }

        // loga o usuário
        Auth::login($user);

        // regenera sessão
        $request->session()->regenerate();

        // redireciona para a página correta
        if ($user->is_admin == 1) {
            return redirect('/admin');
        } else {
            return redirect()->route('usuario');
        }
    }

    public function logout(Request $request)
{
    // pega o carrinho atual (se existir) antes de invalidar a sessão
    $carrinho = $request->session()->get('carrinho', []);

    // desloga o usuário
    Auth::logout();

    // invalida sessão antiga (limpa dados de sessão) e regenera token
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // cria nova sessão e restaura o carrinho salvo antes
    $request->session()->put('carrinho', $carrinho);

    // redireciona para a home (ou para onde preferir)
    return redirect('/')->with('msg', 'Desconectado com sucesso.');
}
}