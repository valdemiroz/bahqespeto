<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    // Mostrar página de pagamento
    public function mostrarPagamento(Request $request)
    {
        $itens = session('carrinho', []);          // Itens do carrinho
        $totalCarrinho = session('carrinho_total', 0); // Total do carrinho

        // Garantir que $itens seja sempre array
        if (!is_array($itens)) {
            $itens = [];
        }

        return view('pagamento', compact('itens', 'totalCarrinho'));
    }

    // Finalizar pedido (POST)
    public function finalizarPedido(Request $request)
    {
        $carrinho = session('carrinho', []);
        if (empty($carrinho)) {
            return redirect()->route('carrinho')->with('erro', 'Seu carrinho está vazio!');
        }

        $usuario = Auth::user(); // Usuário logado

        $total = $request->input('total');
        $formaPagamento = $request->input('pagamento');
        $valorPago = $request->input('valor_pago', $total);
        $troco = $formaPagamento === 'dinheiro' ? $valorPago - $total : 0;

        // Salvar pedido com informações completas do usuário
        Pedido::create([
            'usuario' => $usuario->usuario,
            'email' => $usuario->email,
            'telefone' => $usuario->telefone,
            'endereco' => $usuario->endereco,
            'itens' => json_encode($carrinho, JSON_UNESCAPED_UNICODE),
            'total' => $total,
            'forma_pagamento' => $formaPagamento,
            'valor_pago' => $valorPago,
            'troco' => $troco,
            'data' => now(),
        ]);

        // Limpa carrinho
        session()->forget('carrinho');
        session()->forget('carrinho_total');

        // Redireciona para página de sucesso, enviando dados do pedido
        return redirect()->route('pedido.sucesso')->with([
            'itens' => $carrinho,
            'total' => $total,
            'formaPagamento' => $formaPagamento,
            'valorPago' => $valorPago,
            'troco' => $troco
        ]);
    }

    // Página de sucesso do pedido (GET)
    public function sucesso()
    {
        // Recupera dados da sessão
        $itens = session('itens', []);
        $total = session('total', 0);
        $formaPagamento = session('formaPagamento', '');
        $valorPago = session('valorPago', 0);
        $troco = session('troco', 0);

        return view('pedido_sucesso', compact('itens', 'total', 'formaPagamento', 'valorPago', 'troco'));
    }

    // Listar pedidos no admin
    public function index()
    {
        $pedidos = Pedido::orderByDesc('data')->get();

        return view('admin.index', compact('pedidos'));
    }

    // Deletar pedido
    public function destroy($id)
    {
        Pedido::findOrFail($id)->delete();
        return redirect()->route('admin')->with('sucesso', 'Pedido removido com sucesso!');
    }
}
