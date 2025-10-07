<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{
    // GET /carrinho
    public function index(Request $request)
    {
        // Se por algum motivo não estiver autenticado (fallback)
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Não autorizado. Faça login.'], 401);
            }
            return redirect()->route('login')->with('msg', 'Você precisa estar logado para acessar o carrinho.');
        }

        $carrinho = session('carrinho', []);
        return view('carrinho', compact('carrinho'));
    }

    // POST /carrinho/remover
    public function remover(Request $request)
    {
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Não autorizado. Faça login.'], 401);
            }
            return redirect()->route('login')->with('msg', 'Você precisa estar logado para acessar o carrinho.');
        }

        $produto = $request->input('remover');
        $carrinho = session('carrinho', []);

        if ($produto && isset($carrinho[$produto])) {
            $carrinho[$produto]['quantidade']--;
            if ($carrinho[$produto]['quantidade'] <= 0) {
                unset($carrinho[$produto]);
            }
        }

        session(['carrinho' => $carrinho]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'carrinho_vazio' => empty($carrinho),
            ]);
        }

        return redirect()->route('carrinho');
    }
}
