{{-- resources/views/pagamento.blade.php --}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pagamento - BahQEspetos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/bahqespeto.png') }}">
    <style>
        /* garantia: campos escondidos inicialmente */
        #campoValorPago, #qrPix, #dadosCartao {
            display: none;
        }
        /* ajuste simples para inputs do cartão (opcional, você pode mover pro CSS) */
        .cartao-group label { display:block; margin-top:8px; }
        .cartao-group input { width:100%; padding:6px; box-sizing:border-box; }
    </style>
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

        {{-- Campo Troco (aparece só quando "dinheiro" selecionado) --}}
        <div id="campoValorPago">
            <label for="valor_pago">Troco para:</label>
            <input type="number" step="0.01" id="valor_pago" name="valor_pago">
        </div>

        {{-- QR Pix (aparece só quando "pix" selecionado) --}}
        <div id="qrPix">
            <p>Escaneie o QR Code para pagar via Pix:</p>
            {{-- substitua a URL abaixo pela sua geração de QR real ou chave dinâmica --}}
            <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode('chave-pix-exemplo') }}&size=150x150" alt="QR Code Pix">
            {{-- Se quiser, adicione um campo oculto com a chave para o backend --}}
            <input type="hidden" name="pix_chave" value="chave-pix-exemplo">
        </div>

        {{-- Campos do Cartão (aparecem só quando "cartao" selecionado) --}}
        <div id="dadosCartao" class="cartao-group">
            <label for="nome_cartao">Nome no cartão:</label>
            <input type="text" id="nome_cartao" name="nome_cartao" placeholder="Como aparece no cartão">

            <label for="numero_cartao">Número do cartão:</label>
            <input type="text" id="numero_cartao" name="numero_cartao" maxlength="19" placeholder="XXXX XXXX XXXX XXXX">

            <label for="validade_cartao">Validade (MM/AA):</label>
            <input type="text" id="validade_cartao" name="validade_cartao" maxlength="5" placeholder="MM/AA">

            <label for="cvv_cartao">CVV:</label>
            <input type="text" id="cvv_cartao" name="cvv_cartao" maxlength="4" placeholder="3 ou 4 dígitos">
        </div>

        <button type="submit" style="margin-top:10px;color:white">Finalizar Pedido</button><br><br>
    </form>

    <p style="margin-top:10px;">
        <a href="{{ url('carrinho') }}" style="text-decoration:none;background-color:orange;padding:15px;border-radius:10px;margin-left:115px;color:white;font-weight:bold">Voltar ao carrinho</a>
    </p>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const pagamentoSelect = document.getElementById('pagamento');
    const campoValorPago = document.getElementById('campoValorPago');
    const qrPix = document.getElementById('qrPix');
    const dadosCartao = document.getElementById('dadosCartao');

    // função que atualiza visibilidade baseada no valor atual do select
    function atualizarCampos() {
        if (!pagamentoSelect) return;
        const tipo = pagamentoSelect.value;
        if (campoValorPago) campoValorPago.style.display = (tipo === 'dinheiro') ? 'block' : 'none';
        if (qrPix) qrPix.style.display = (tipo === 'pix') ? 'block' : 'none';
        if (dadosCartao) dadosCartao.style.display = (tipo === 'cartao') ? 'block' : 'none';
    }

    // dispara quando troca o select
    if (pagamentoSelect) pagamentoSelect.addEventListener('change', atualizarCampos);

    // atualiza na carga da página (útil se o valor vem de request ou se o usuário volta à página)
    atualizarCampos();
});
</script>
</body>
</html>
