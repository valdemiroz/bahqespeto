<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'usuario', 'email', 'telefone', 'endereco',
        'itens', 'total', 'forma_pagamento', 'valor_pago', 'troco', 'data'
    ];

    public $timestamps = false;

    // Adicione isto:
    protected $casts = [
        'itens' => 'array',
        'total' => 'float',
        'valor_pago' => 'float',
        'troco' => 'float',
        'data' => 'datetime',
    ];

    public function usuarioRelacionamento()
    {
        return $this->belongsTo(User::class, 'usuario');
    }
}

