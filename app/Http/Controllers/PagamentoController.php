<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;

class PagamentoController extends Controller
{
    public function show(Request $request)
    {
        $total = $request->total;
        return view('pagamento', compact('total'));
    }

    public function confirmar(Request $request)
    {
        $carrinho = session('carrinho', []);
        $total = $request->total;
        $forma = $request->pagamento;
        $valorPago = $request->valor_pago ?? $total;
        $troco = $valorPago - $total;

        Pedido::create([
            'usuario_id' => Auth::id(),
            'itens' => json_encode($carrinho, JSON_UNESCAPED_UNICODE),
            'total' => $total,
            'forma_pagamento' => $forma,
            'valor_pago' => $valorPago,
            'troco' => $troco
        ]);

        session()->forget('carrinho');

        return redirect()->route('pedido.sucesso');
    }

    public function sucesso()
    {
        return view('pedido_sucesso');
    }
}
