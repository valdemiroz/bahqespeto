<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    // aponta para a tabela EXISTENTE que você descreveu
    protected $table = 'usuarios';

    // PK padrão 'id' está ok, mas deixe explícito
    protected $primaryKey = 'id';

    // se a tabela NÃO usa created_at/updated_at no padrão, desative timestamps
    public $timestamps = false;

    // se sua coluna de criação é 'criado_em' e você quiser que o Eloquent trate automaticamente,
    // você poderia descomentar e ajustar (mas só faça se tiver updated_at também)
    // const CREATED_AT = 'criado_em';
    // public $timestamps = true;

    // campos preenchíveis (ajuste se tiver outros)
    protected $fillable = [
        'usuario',
        'senha',
        'telefone',
        'endereco',
        'email',
        'foto',
        'criado_em'
    ];

    // não exponha o campo de senha em JSON
    protected $hidden = [
        'senha',
    ];

    // informa ao Laravel qual campo usar como senha para Auth
    public function getAuthPassword()
    {
        // sua coluna de senha se chama 'senha'
        return $this->senha;
    }
}
