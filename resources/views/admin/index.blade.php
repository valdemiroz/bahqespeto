<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Painel de Administração</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; color: #333; padding: 20px; }
    h1, h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
    table, th, td { border: 1px solid #ccc; }
    th, td { padding: 8px; text-align: center; }
    a.btn { padding: 6px 12px; background: orange; color: white; text-decoration: none; border-radius: 5px; }
    a.btn:hover { background: darkorange; }
    form { display: inline; }
    img { max-width: 100px; height: auto; }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<h1>Painel de Administração</h1>
<div style="text-align:center;margin-bottom:20px;">
    <a href="{{ url('admin/novo_produto') }}" class="btn">Adicionar Produto</a>
    <a href="{{ url('/') }}" class="btn" style="background:gray;">Sair do Admin</a>
</div>

<h2>Produtos</h2>
<table>
    <thead>
        <tr><th>ID</th><th>Nome</th><th>Preço</th><th>Imagem</th><th>Ações</th></tr>
    </thead>
    <tbody>
        @foreach($produtos as $p)
        <tr id="produto-{{ $p->id }}">
            <td>{{ $p->id }}</td>
            <td>{{ $p->nome }}</td>
            <td>R$ {{ number_format($p->preco,2,',','.') }}</td>
            <td>
    @if($p->imagem)
        <img src="{{ asset('img/' . $p->imagem) }}" alt="{{ $p->nome }}">
    @endif
</td>
            <td>
                <a href="{{ url('admin/editar_produto/'.$p->id) }}" class="btn">Editar</a>
                <button class="btn" style="background:red;" onclick="deletarProduto({{ $p->id }})">Excluir</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<h2>Pedidos Realizados</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Usuário</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Endereço</th>
        <th>Total</th>
        <th>Pagamento</th>
        <th>Ações</th>
    </tr>
    @foreach($pedidos as $pedido)
        <tr>
            <td>{{ $pedido->id }}</td>
            <td>{{ $pedido->usuario }}</td>
            <td>{{ $pedido->email }}</td>
            <td>{{ $pedido->telefone }}</td>
            <td>{{ $pedido->endereco }}</td>
            <td>R$ {{ number_format($pedido->total,2,',','.') }}</td>
            <td>{{ ucfirst($pedido->forma_pagamento) }}</td>
            <td>
                <form action="{{ route('admin.deletarPedido', $pedido->id) }}" method="POST" onsubmit="return confirm('Deseja realmente remover este pedido?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Remover</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

<script>
function deletarPedido(id) {
    if(!confirm('Deseja remover este pedido?')) return;
    fetch('/admin/pedidos/' + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
    }).then(res => {
        if(res.ok) document.getElementById('pedido-' + id).remove();
        else alert('Erro ao remover pedido');
    });
}
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function deletarPedido(id){
    if(!confirm('Deseja remover este pedido?')) return;
    $.ajax({
        url:'/admin/pedidos/'+id,
        type:'DELETE',
        headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        success:function(){ $('#pedido-'+id).remove(); },
        error:function(){ alert('Erro ao remover pedido'); }
    });
}
</script>

</body>
</html>
