<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Seu Carrinho</title>
<link rel="shortcut icon" href="{{ asset('img/bahqespeto.png') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    /* ====== CSS fiel ao original ====== */
    body{
        color: white;
        background: linear-gradient(to bottom, orange, rgb(255, 25, 0), rgb(29,29,29));
        font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        height: auto;
    }

    .topo{
        background-color: rgb(45, 45, 45);
        box-sizing: border-box;
        padding: 15px;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        width: 100%;
        z-index: 999;
    }

    a:link{
        margin-top: 10px;
        text-indent: 20px;
        text-decoration: none;
    }

    a p{
        color: white;
        text-indent: 30px;
    }

    .pesquisa {
        margin-left: 30px;
        text-indent: 20px;
        height: 50px;
        margin-top: 15px;
        width: 400px;
        border-style: none;
        border-radius: 30px;
        scroll-behavior: smooth;
        padding-left: 15px;
        color: white;

    }

    .search-container {
        position: relative;
        width: 300px;
    }

    .sugestoes {
        position: absolute;
        top: 100%;
        left: 0px;
        right: 0;
        background: rgb(45, 45, 45);
        list-style: none;
        margin: 0;
        padding: 0;
        max-height: 200px;
        overflow-y: auto;
        z-index: 10;
        border-radius: 6px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.4);
    }

    .sugestoes li {
        padding: 8px;
        cursor: pointer;
        color: white;
    }

    .sugestoes li:hover {
        background-color: rgb(69, 69, 69);
    }

    i.fa-bars{
        color: white;
        font-size: 40px;
        position:absolute;
        right: 45px;
        top: 35px;
    }

    /* Menu lateral */
    #menu-toggle {
        cursor: pointer;
        position: fixed;
        z-index: 1001;
    }

    #sidebar {
        position: fixed;
        top: 0;
        right: 0;
        width: 300px;
        height: 100%;
        background-color: rgb(45, 45, 45);
        color: white;
        padding: 20px;
        z-index: 1000;
        transition: transform 0.4s ease;
        transform: translateX(100%);
        display: none;
    }

    #sidebar.active {
        transform: translateX(0);
        display: block;
    }

    #close-btn {
        font-size: 28px;
        cursor: pointer;
        position: absolute;
        top: 15px;
        left: 15px;
    }

    #sidebar ul {
        list-style: none;
        padding: 60px 0 0 0;
    }

    #sidebar ul li {
        margin: 20px 0;
    }

    #sidebar ul li a {
        color: white;
        text-decoration: none;
        font-size: 18px;
    }

    @media (max-width: 600px) {
        a:link {
            margin-top: 10px;
            text-indent: 10px;
        }

        a p {
            text-indent: 10px;
            font-size: 16px;
        }

        .pesquisa {
            width: 200px;
            text-indent: 35px;
            margin-left: 45px;
            height: 40px;
            margin-top: 20px;
        }
    }

    .cont {
        color: rgb(216, 143, 59);
        text-align: center;
        background-color: rgb(29, 29, 29);
        box-sizing: border-box;
        width: 90%;
        max-width: 1000px;
        position: relative;
        margin: 200px auto auto;
        border-radius: 50px;
        padding: 30px;
    }

    .cont h1 { font-size: 50px; }
    .cont hr { margin-bottom: 30px; width: 50%; }
    .cont p { padding: 15px; font-size: 15px; }

    /* Carrinho específico */
    .usuario {
        max-width: 900px;
        margin: auto;
        margin-top: 150px;
        margin-bottom: 25px;
        position: relative;
        padding: 20px;
        background-color: #232323;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .usuario h2 {
        text-align: center;
        color: #fff;
        margin-top: 0;
    }

    .carrinho table { border-collapse: collapse; width: 100%; margin: 20px auto; }
    .carrinho th, .carrinho td { border: none; padding: 10px; text-align: center; color: white; }
    .carrinho button { padding: 5px 10px; background:orange; color: white; border: none; cursor: pointer; border-radius: 5px; }
    .carrinho button:hover { background: darkorange; }
    .msg { background: #d9edf7; padding: 10px; border: 1px solid #31708f; color: #31708f; margin: 10px auto; width: 80%; border-radius: 6px; text-align:center; }

    .aviso-vazio {
        color: red;
        font-weight: bold;
        margin-top: 10px;
        text-align: center;
    }

    .checkout-btn {
        padding:12px 18px; margin-right:12px;background-color:orange;border-radius:10px;color:white;border:none
    }
    .checkout-btn:disabled { background-color: gray; cursor: not-allowed; }

    .fim {
        text-align: center;
        padding: 15px;
        box-sizing: border-box;
        width: 100%;
        height: auto;
        background-color: rgb(45, 45, 45);
        position: relative;
        margin-top: 140px;
    }
</style>
</head>
<body><!-- TOPO (usuário, pesquisa, menu) -->
    <div class="topo">
        {{-- Usuário --}}
        <a href="{{ Auth::check() ? url('/usuario') : url('/login') }}" style="display:flex; align-items:center;">
            @if(Auth::check())
                @if(Auth::user()->foto && file_exists(public_path(Auth::user()->foto)))
                    <img src="{{ asset(Auth::user()->foto) }}" alt="Usuário" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:8px;">
                @else
                    <i class="fa fa-user" style="color:white;font-size:40px;margin-right:8px;"></i>
                @endif
                <p>{{ Auth::user()->usuario }}</p>
            @else
                <i class="fa fa-user" style="color:white;font-size:40px;margin-right:8px;"></i>
                <p>usuário</p>
            @endif
        </a>

        <div class="search-container">
            <input type="text" id="pesquisa" class="pesquisa" placeholder="Buscar item..." autocomplete="off" />
            <ul id="sugestoes" class="sugestoes"></ul>
        </div>

        <i class="fa fa-bars" id="menu-toggle"></i>
        <div id="sidebar">
            <span id="close-btn">&times;</span>
            <ul>
                <li><a href="{{ route('cardapio') }}">Nosso cardápio</a></li>
                <li><a href="#" onclick="acessarAdmin()">Sou Admin</a></li>

<script>
function acessarAdmin() {
    const codigo = prompt("Digite o código de acesso:");
    if(codigo === "02933") {
        // Redireciona direto para a página admin
        window.location.href = "/admin";
    } else if(codigo !== null) {
        alert("Código incorreto!");
    }
}
</script>
                <li><a href="{{ route('carrinho') }}">Seu Carrinho</a></li>
                <li><a href="{{ url('/') }}">Voltar ao início</a></li>
            </ul>
        </div>
    </div>

    <!-- SCRIPTS DO TOPO (pesquisa, sugestões, menu, admin) -->
    <script>
        // (mantenha seu JS de sugestões/menu aqui)
        const itensSugestao = [
          "Tricolor", "Laçador", "Beira-rio", "Gurizinho", "Chinelão", "Cidade Baixa",
          "Moinhos", "Farrapos", "Guaíba", "Água", "Cerveja", "Refrigerante",
          "Batata frita", "Pão de alho", "Pão de queijo"
        ];
        const inputPesquisa = document.getElementById("pesquisa");
        const sugestoesElem = document.getElementById("sugestoes");
        function mostrarSugestoes(lista) {
          sugestoesElem.innerHTML = "";
          lista.forEach(item => {
            const li = document.createElement("li");
            li.textContent = item;
            li.onclick = () => {
              inputPesquisa.value = item;
              sugestoesElem.innerHTML = "";
            };
            sugestoesElem.appendChild(li);
          });
        }
        inputPesquisa.addEventListener("focus", () => { mostrarSugestoes(itensSugestao); });
        inputPesquisa.addEventListener("input", () => {
          const valor = inputPesquisa.value.trim().toLowerCase();
          if (valor.length === 0) { mostrarSugestoes(itensSugestao); return; }
          const filtrados = itensSugestao.filter(item => item.toLowerCase().startsWith(valor));
          mostrarSugestoes(filtrados);
        });
        inputPesquisa.addEventListener("keydown", (e) => {
          if (e.key === "Enter") { e.preventDefault(); window.location.href = "{{ route('cardapio') }}"; }
        });
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const closeBtn = document.getElementById('close-btn');
        menuToggle.addEventListener('click', () => { sidebar.style.display = 'block'; setTimeout(() => { sidebar.classList.add('active'); }, 10); });
        closeBtn.addEventListener('click', () => { sidebar.classList.remove('active'); setTimeout(() => { sidebar.style.display = 'none'; }, 400); });
        document.addEventListener("click", (e) => { if (!e.target.closest(".search-container")) { sugestoesElem.innerHTML = ""; } });
    </script>

    <!-- CONTEÚDO: CARRINHO -->
    <div class="usuario">
        <h2>Seu Carrinho</h2>

        @if(session('msg'))
            <div class="msg">{{ session('msg') }}</div>
        @endif

        @php $carrinho = session('carrinho', []); @endphp

        @if(empty($carrinho))
            <p style="text-align:center;">Carrinho vazio.</p>
            <div style="text-align:center; margin-top:15px;">
                <a href="{{ route('cardapio') }}"><button style="padding:12px 18px; margin-right:12px;background-color:orange;border-radius:10px;color:white;border:none">Voltar ao Cardápio</button></a>
                <button class="checkout-btn" disabled>Finalizar Pagamento</button>
                <p class="aviso-vazio">Carrinho vazio! Adicione itens antes de finalizar.</p>
            </div>
        @else
            <div class="carrinho">
                <table>
                  <tr>
                    <th>Produto</th>
                    <th>Preço Unitário</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                    <th>Ação</th>
                  </tr>

                @php $totalGeral = 0; @endphp

                @foreach($carrinho as $nome => $item)
                    @php
                        $total = $item['preco'] * $item['quantidade'];
                        $totalGeral += $total;
                        $rowId = 'row-' . \Illuminate\Support\Str::slug($nome);
                    @endphp
                    <tr id="{{ $rowId }}" data-nome="{{ $nome }}" data-quantidade="{{ $item['quantidade'] }}" data-preco="{{ $item['preco'] }}">
                      <td>{{ $nome }}</td>
                      <td>R$ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                      <td class="qtd">{{ $item['quantidade'] }}</td>
                      <td class="subtotal">R$ {{ number_format($total, 2, ',', '.') }}</td>
                      <td>
                        <form class="remover-form" action="{{ route('carrinho.remover') }}" method="post" style="margin:0;">
                            @csrf
                            <input type="hidden" name="remover" value="{{ $nome }}">
                            <button type="submit">Remover</button>
                        </form>
                      </td>
                    </tr>
                @endforeach
                </table>

                <h2 style="text-align:center;">Total Geral: <span id="total-geral">R$ {{ number_format($totalGeral, 2, ',', '.') }}</span></h2>

                <div style="text-align:center;">
                    <a href="{{ route('cardapio') }}"><button style="padding:12px 18px; margin-right:12px;">Voltar ao Cardápio</button></a>

                    {{-- Se estiver logado, levar ao pagamento; se não, mostrar botão que leva ao login --}}
                    @if(Auth::check())
                        <form action="{{ route('pagamento') }}" method="get" style="display:inline-block;">
                            <input type="hidden" name="total" value="{{ $totalGeral }}">
                            <button type="submit" style="padding:12px 18px; margin-right:12px;background-color:orange;border-radius:10px;color:white;border:none">Finalizar Pagamento</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="checkout-btn" style="padding:12px 18px; margin-right:12px;background-color:gray;border-radius:10px;color:white;border:none;text-decoration:none;">Fazer login para finalizar</a>
                        <p class="aviso-vazio">Faça login para poder finalizar o pagamento. Seus itens permanecerão salvos no carrinho.</p>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- RODAPÉ -->
    <div class="fim" style="top:85px">
        <p>©2025 BAHQESPETOS<br>
        Trazendo a cultura gaúcha com muito sabor<br>
        <a href="https://www.facebook.com" class="fa fa-facebook-official" style="color:white;font-size:32px" aria-hidden="true"></a>
        <a href="https://www.instagram.com" class="fa fa-instagram" style="color:white;font-size:32px" aria-hidden="true"></a><br><br>
        CNPJ: 10.978.458/0999-10<br>
        Av. Guilherme Schell, 478 - Canoas, RS
        </p>
    </div>

    <script>
        // aqui você pode interceptar os forms de remoção para usar AJAX, se quiser
        document.querySelectorAll('.remover-form').forEach(form => {
            form.addEventListener('submit', function(e){
                // deixa o comportamento normal (POST) — ou comente abaixo para usar AJAX
                // e.preventDefault();
                // implementa fetch/AJAX se preferir
            });
        });
    </script>

</body>
</html>
