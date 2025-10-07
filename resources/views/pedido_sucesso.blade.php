<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pedido Concluído - BahQEspetos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('img/bahqespeto.png') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        body { font-family: 'Gill Sans', sans-serif; background-color: #1d1d1d; color: white; }
        .container { max-width: 900px; margin: 50px auto; background-color: #232323; padding: 20px; border-radius: 10px; }
        h1 { text-align: center; color: orange; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 10px; text-align: center; }
        th { background-color: orange; color: black; }
        .total { font-weight: bold; }
        .botoes { margin-top: 20px; text-align: center; }
        .botoes a, .botoes button { background-color: orange; color: white; padding: 10px 15px; border-radius: 10px; border: none; text-decoration: none; margin: 5px; cursor: pointer; }
        .logo { text-align: center; margin-bottom: 20px; }
        .logo img { width: 120px; }
        .dados-cliente { margin-top: 10px; }
        .dados-cliente p { margin: 3px 0; }
        @media print {
            body { background-color: white; color: black; }
            .botoes, .topo, .fim { display: none; }
            .container { background-color: white; color: black; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="{{ asset('img/bahqespeto.png') }}" alt="Logo BahQEspetos">
    </div>
    <h1>COMPRA FINALIZADA!</h1>
    <p style="text-align:center;">Seu pedido foi realizado com sucesso. Agradecemos por comprar conosco!</p>

    {{-- Dados do cliente --}}
    <div class="dados-cliente">
        <p><strong>Nome:</strong> {{ Auth::user()->usuario }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        <p><strong>Telefone:</strong> {{ Auth::user()->telefone ?? 'Não informado' }}</p>
        <p><strong>Endereço:</strong> {{ Auth::user()->endereco ?? 'Não informado' }}</p>
    </div>

    {{-- Dados enviados via session --}}
@php
$itens = session('itens', []);
$formaPagamento = session('formaPagamento', '');
$valorPago = session('valorPago', 0);
$troco = session('troco', 0);
@endphp

{{-- Itens do pedido --}}
<table>
    <tr>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Preço Unitário</th>
        <th>Total</th>
    </tr>
    @php $total = 0; @endphp
    @foreach($itens as $nome => $item)
        @php
            $subtotal = $item['preco'] * $item['quantidade'];
            $total += $subtotal;
        @endphp
        <tr>
            <td>{{ $nome }}</td>
            <td>{{ $item['quantidade'] }}</td>
            <td>R$ {{ number_format($item['preco'],2,',','.') }}</td>
            <td>R$ {{ number_format($subtotal,2,',','.') }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3"><strong>Total</strong></td>
        <td>R$ {{ number_format($total,2,',','.') }}</td>
    </tr>
</table>

<p><strong>Forma de pagamento:</strong> {{ $formaPagamento }}</p>
<p><strong>Valor pago:</strong> R$ {{ number_format($valorPago,2,',','.') }}</p>
@if($formaPagamento === 'dinheiro')
<p><strong>Troco:</strong> R$ {{ number_format($troco,2,',','.') }}</p>
@endif


    {{-- Pagamento --}}
    <div class="dados-cliente" style="margin-top: 20px;">
        <p><strong>Forma de Pagamento:</strong> {{ $formaPagamento }}</p>
        <p><strong>Valor Pago:</strong> R$ {{ number_format($valorPago, 2, ',', '.') }}</p>
        @if($formaPagamento === 'dinheiro')
            <p><strong>Troco:</strong> R$ {{ number_format($troco, 2, ',', '.') }}</p>
        @endif
    </div>

    {{-- Botões --}}
    <div class="botoes">
        <button onclick="window.print()">Imprimir Recibo</button><br><br>
        <a href="https://wa.me/555191628190" target="_blank">Contatar pelo WhatsApp</a>
        <a href="{{ url('/') }}">Voltar ao Início</a>
        <a href="{{ route('cardapio') }}">Continuar Comprando</a>
    </div>
</div>
</body>
</html>
