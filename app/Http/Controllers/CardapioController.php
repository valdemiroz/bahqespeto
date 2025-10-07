<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class CardapioController extends Controller
{
    public function index()
    {
        $produtos = Produto::orderBy('categoria')->orderBy('nome')->get()->groupBy('categoria');
        return view('cardapio', compact('produtos'));
    }

    public function adicionarCarrinho(Request $request)
    {
        $request->validate([
            'produto' => 'required|string',
            'preco' => 'required|numeric',
            'quantidade' => 'required|integer|min:1',
        ]);

        $carrinho = session()->get('carrinho', []);

        $produto = $request->produto;
        $preco = $request->preco;
        $quantidade = $request->quantidade;

        if(isset($carrinho[$produto])) {
            $carrinho[$produto]['quantidade'] += $quantidade;
        } else {
            $carrinho[$produto] = [
                'preco' => $preco,
                'quantidade' => $quantidade
            ];
        }

        session(['carrinho' => $carrinho]);
        session()->flash('msg', "$produto foi adicionado ao seu carrinho!");

        return redirect()->route('cardapio');
    }
}
