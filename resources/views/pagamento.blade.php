{{-- resources/views/pagamento.blade.php --}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pagamento - BahQEspetos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/bahqespeto.png') }}">
</head>
<body>
<div class="container">
    <h1>Finalizar Pagamento</h1>

    {{-- Valor do carrinho --}}
    @php
    $totalCarrinho = request()->get('total', 0);
@endphp

<form method="POST" action="{{ route('pedido.finalizar') }}">
    @csrf
    <label for="valor">Valor da compra (R$):</label>
    <input type="number" step="0.01" id="valor" name="total" required
           value="{{ number_format($totalCarrinho, 2, '.', '') }}" readonly>

    <label for="pagamento">Forma de pagamento:</label>
    <select id="pagamento" name="pagamento" required>
        <option value="pix">Pix</option>
        <option value="dinheiro">Dinheiro</option>
        <option value="cartao">Cartão</option>
    </select>

    <div id="campoValorPago" style="display:none;">
        <label for="valor_pago">Troco para:</label>
        <input type="number" step="0.01" id="valor_pago" name="valor_pago">
    </div>

    <button type="submit" style="margin-top:10px;">Finalizar Pedido</button>
</form>

</div>

<script>
const pagamentoSelect = document.getElementById('pagamento');
const campoValorPago = document.getElementById('campoValorPago');
const qrPix = document.getElementById('qrPix');
const dadosCartao = document.getElementById('dadosCartao');

pagamentoSelect.addEventListener('change', () => {
    const tipo = pagamentoSelect.value;
    campoValorPago.style.display = tipo === 'dinheiro' ? 'block' : 'none';
    qrPix.style.display = tipo === 'pix' ? 'block' : 'none';
    dadosCartao.style.display = tipo === 'cartao' ? 'block' : 'none';
});
</script>
</body>
</html>
