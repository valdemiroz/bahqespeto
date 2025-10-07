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

    public function usuarioRelacionamento()
    {
        return $this->belongsTo(User::class, 'usuario');
    }
}
