<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Pedido;

class ProdutoController extends Controller
{
    // Painel admin
    public function adminIndex()
    {
        $produtos = Produto::all();
        $pedidos = Pedido::with('usuario')->get(); // assumes relação com usuário
        return view('admin.index', compact('produtos','pedidos'));
    }

    public function create()
    {
        return view('admin.novo_produto');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'descricao' => 'required|string',
            'preco' => 'required|numeric',
            'imagem' => 'nullable|image|max:2048',
        ]);

        $produto = new Produto();
        $produto->nome = $request->nome;
        $produto->descricao = $request->descricao;
        $produto->preco = $request->preco;

        if ($request->hasFile('imagem')) {
            $produto->imagem = $request->file('imagem')->store('produtos','public');
        }

        $produto->save();

        return redirect()->route('admin.index')->with('success', 'Produto adicionado!');
    }

    public function edit(Produto $produto)
    {
        return view('admin.editar_produto', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'nome' => 'required|string',
            'descricao' => 'required|string',
            'preco' => 'required|numeric',
            'imagem' => 'nullable|image|max:2048',
        ]);

        $produto->nome = $request->nome;
        $produto->descricao = $request->descricao;
        $produto->preco = $request->preco;

        if ($request->hasFile('imagem')) {
            $produto->imagem = $request->file('imagem')->store('produtos','public');
        }

        $produto->save();

        return redirect()->route('admin.index')->with('success', 'Produto atualizado!');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('admin.index')->with('success', 'Produto removido!');
    }
}