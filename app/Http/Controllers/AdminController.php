<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Pedido;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Exibe painel de administração
    public function index()
{
    $produtos = Produto::orderByDesc('id')->get();
    $pedidos = Pedido::orderByDesc('data')->get();
    return view('admin.index', compact('produtos', 'pedidos'));
}


    // Exibe formulário para criar produto
    public function novoProduto()
    {
        return view('admin.novo_produto');
    }

    // Salva produto novo
    public function salvarProduto(Request $request)
{
    $request->validate([
        'nome' => 'required|string',
        'descricao' => 'required|string',
        'preco' => 'required|numeric',
        'categoria' => 'required|string', // validação da categoria
        'imagem' => 'nullable|image'
    ]);

    $produto = new Produto();
    $produto->nome = $request->nome;
    $produto->descricao = $request->descricao;
    $produto->preco = $request->preco;
    $produto->categoria = $request->categoria; // salva a categoria

    if ($request->hasFile('imagem')) {
        $arquivo = $request->file('imagem');
        $nomeArquivo = time().'_'.$arquivo->getClientOriginalName();
        $arquivo->move(public_path('img'), $nomeArquivo);
        $produto->imagem = $nomeArquivo;
    }

    $produto->save();

    return redirect('admin')->with('sucesso','Produto adicionado com sucesso!');
}

    // Exibe formulário para editar produto
    public function editarProduto($id)
    {
        $produto = Produto::findOrFail($id);
        return view('admin.editar_produto', compact('produto'));
    }

    // Atualiza produto
    public function atualizarProduto(Request $request, $id)
{
    $request->validate([
        'nome' => 'required|string',
        'descricao' => 'required|string',
        'preco' => 'required|numeric',
        'categoria' => 'required|string', // validação da categoria
        'imagem' => 'nullable|image'
    ]);

    $produto = Produto::findOrFail($id);
    $produto->nome = $request->nome;
    $produto->descricao = $request->descricao;
    $produto->preco = $request->preco;
    $produto->categoria = $request->categoria; // atualiza a categoria

    if ($request->hasFile('imagem')) {
        $arquivo = $request->file('imagem');
        $nomeArquivo = time().'_'.$arquivo->getClientOriginalName();
        $arquivo->move(public_path('img'), $nomeArquivo);
        $produto->imagem = $nomeArquivo;
    }

    $produto->save();

    return redirect('admin')->with('sucesso','Produto atualizado com sucesso!');
}


    public function deletarProduto($id)
{
    $produto = Produto::findOrFail($id);
    if ($produto->imagem && file_exists(public_path('img/'.$produto->imagem))) {
        unlink(public_path('img/'.$produto->imagem));
    }
    $produto->delete();

    return response()->json(['success' => true]); // ✅ Retorno JSON
}

public function deletarPedido($id)
{
    $pedido = Pedido::findOrFail($id);
    $pedido->delete();
    return redirect()->back()->with('sucesso', 'Pedido removido com sucesso!');
}
}