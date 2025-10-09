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
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Itens (resumo)</th>
            <th>Total</th>
            <th>Valor Pago</th>
            <th>Troco</th>
            <th>Pagamento</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    @foreach($pedidos as $pedido)
        @php
            // Se armazenamento for JSON string -> decodifica, se já for array -> usa direto
            $itensPedido = [];
            if (!empty($pedido->itens)) {
                if (is_string($pedido->itens)) {
                    $decoded = json_decode($pedido->itens, true);
                    $itensPedido = is_array($decoded) ? $decoded : [];
                } elseif (is_array($pedido->itens)) {
                    $itensPedido = $pedido->itens;
                }
            }
            // calcula total localmente (caso queira conferir)
            $totalCalc = 0;
            foreach($itensPedido as $nome => $item){
                // suporte a formatos: ['nome'=>..., 'preco'=>..., 'quantidade'=>...] ou ['preco'=>..., 'quantidade'=>...]
                $preco = isset($item['preco']) ? (float)$item['preco'] : 0;
                $qtd = isset($item['quantidade']) ? (int)$item['quantidade'] : (isset($item['qty']) ? (int)$item['qty'] : 1);
                $totalCalc += $preco * $qtd;
            }
        @endphp
        <tr id="pedido-{{ $pedido->id }}">
            <td>{{ $pedido->id }}</td>
            <td>{{ $pedido->usuario }}</td>
            <td>{{ $pedido->email }}</td>
            <td>{{ $pedido->telefone }}</td>
            <td>{{ $pedido->endereco }}</td>

            {{-- Resumo de itens: exibir "Nome x qtd" em uma lista pequena --}}
            <td style="text-align:left;">
                @if(count($itensPedido) === 0)
                    <small>— Sem itens —</small>
                @else
                    <ul style="list-style:none; padding-left:6px; margin:0; text-align:left;">
                        @foreach($itensPedido as $nome => $item)
                            @php
                                // Se o array for indexado ou tiver 'nome' interno
                                $nomeItem = is_string($nome) ? $nome : ($item['nome'] ?? 'Item');
                                $qtd = $item['quantidade'] ?? $item['qty'] ?? 1;
                                $preco = isset($item['preco']) ? number_format($item['preco'],2,',','.') : '0,00';
                            @endphp
                            <li>{{ $nomeItem }} x {{ $qtd }} — R$ {{ $preco }}</li>
                        @endforeach
                    </ul>
                @endif
            </td>

            <td>R$ {{ number_format($pedido->total,2,',','.') }}</td>

            {{-- Valor pago e troco (troco só para dinheiro; mas mostramos salvo no banco) --}}
            <td>R$ {{ number_format($pedido->valor_pago ?? $pedido->total,2,',','.') }}</td>
            <td>
                @if($pedido->forma_pagamento === 'dinheiro')
                    R$ {{ number_format($pedido->troco ?? 0,2,',','.') }}
                @else
                    R$ 0,00
                @endif
            </td>

            <td>{{ ucfirst($pedido->forma_pagamento) }}</td>

            <td>
                <form action="{{ route('admin.deletarPedido', $pedido->id) }}" method="POST" onsubmit="return confirm('Deseja realmente remover este pedido?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:red;color:white;border:none;padding:6px 10px;border-radius:4px;cursor:pointer;">Remover</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>


<script>
function deletarPedido(id) {
    if(!confirm('Deseja remover este pedido?')) return;
    fetch('/admin/pedidos/' + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
    }).then(res => {
        if (res.ok) {
            const el = document.getElementById('pedido-' + id);
            if (el) el.remove();
        } else {
            res.text().then(t => alert('Erro ao remover pedido: ' + t));
        }
    }).catch(err => alert('Erro: ' + err));
}
</script>


</body>
</html>
