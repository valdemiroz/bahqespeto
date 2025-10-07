<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  {{-- CSS principal --}}
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  {{-- Favicon --}}
  <link rel="shortcut icon" href="{{ asset('img/bahqespeto.png') }}">

  {{-- Font Awesome --}}
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <title>BahQEspetos</title>
</head>
<body>

  {{-- MENU TOPO --}}
  <i class="fa fa-bars" id="menu-toggle"></i>
  <div id="sidebar">
    <span id="close-btn" style="color:white; font-size:30px; cursor:pointer;">&times;</span>
    <ul>
      <li><a href="{{ url('cardapio') }}">Nosso cardápio</a></li>
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
      <li><a href="{{ url('carrinho') }}">Seu Carrinho</a></li>
      <li><a href="{{ url('/') }}">Voltar ao início</a></li>
    </ul>
  </div>

  <div class="topo">
    {{-- Usuário --}}
    
<a href="{{ Auth::check() ? url('/usuario') : url('/login') }}" style="display:flex; align-items:center;">
    @if(Auth::check())
        @if(Auth::user()->foto && file_exists(public_path(Auth::user()->foto)))
            <!-- Mostra a foto enviada pelo usuário -->
            <img src="{{ asset(Auth::user()->foto) }}" 
                 alt="Usuário" 
                 style="width:40px; height:40px; border-radius:50%; object-fit:cover; margin-right:8px;">
        @else
            <!-- Mostra ícone fa-user se não houver foto -->
            <i class="fa fa-user" style="color:white; font-size:40px; margin-right:8px;"></i>
        @endif
        <p>{{ Auth::user()->usuario }}</p>
    @else
        <!-- Ícone padrão quando não logado -->
        <i class="fa fa-user" style="color:white; font-size:40px; margin-right:8px;"></i>
        <p>usuário</p>
    @endif
</a>


    {{-- Campo de pesquisa --}}
    <div class="search-container">
        <input type="text" id="pesquisa" class="pesquisa" placeholder="Buscar item..." autocomplete="off" />
        <ul id="sugestoes" class="sugestoes"></ul>
    </div>
  </div>

  {{-- Conteúdo --}}
  <div class="cont">
    <h1>TRAZENDO A CULTURA GAÚCHA COM MUITO SABOR</h1><hr>
    <p>Representando a culinária gaúcha com diversos petiscos. Escolha o seu agora e faça seu pedido!</p>
  </div>

  <div class="prods">
    <h1>PRODUTOS DISPONÍVEIS</h1>
  </div>

  <div class="corpo">
    <h1 style="color:rgb(234, 172, 66)">APROVEITE DO MELHOR QUE O SUL OFERECE!</h1>
    <div id="sugestoes-container" class="sugestoes-container"></div>
  </div>

  <div class="fim">
    <p>©2025 BAHQESPETOS<br>
    Trazendo a cultura gaúcha com muito sabor!<br>
    <a href="https://www.facebook.com" class="fa fa-facebook-official" style="color:white;font-size:32px"></a>
    <a href="https://www.instagram.com" class="fa fa-instagram" style="color:white;font-size:32px"></a><br><br>
    CNPJ: 10.978.458/0999-10<br>
    Av. Guilherme Schell, 478 - Canoas, RS
    </p>
  </div>

  {{-- SCRIPTS --}}
  <script>
    // ===== MENU =====
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const closeBtn = document.getElementById('close-btn');

    menuToggle.addEventListener('click', () => {
      sidebar.style.display = 'block';
      setTimeout(() => sidebar.classList.add('active'), 10);
    });

    closeBtn.addEventListener('click', () => {
      sidebar.classList.remove('active');
      setTimeout(() => sidebar.style.display = 'none', 300);
    });

    // ===== PESQUISA =====
    const itens = [
      "Tricolor","Laçador","Beira-rio","Gurizinho","Chinelão","Cidade Baixa",
      "Moinhos","Farrapos","Guaíba","Água","Cerveja","Refrigerante",
      "Batata frita","Pão de alho","Pão de queijo","Suco"
    ];

    const input = document.getElementById('pesquisa');
    const sugestoesEl = document.getElementById('sugestoes');

    function mostrarSugestoes(lista){
      sugestoesEl.innerHTML = '';
      lista.forEach(item => {
        const li = document.createElement('li');
        li.textContent = item;
        li.tabIndex = 0;
        li.addEventListener('click', () => input.value = item);
        sugestoesEl.appendChild(li);
      });
    }

    input.addEventListener('focus', () => mostrarSugestoes(itens));
    input.addEventListener('input', () => {
      const valor = input.value.toLowerCase().trim();
      mostrarSugestoes(itens.filter(i => i.toLowerCase().startsWith(valor)));
    });
    input.addEventListener('keydown', (e) => {
      if(e.key === "Enter") window.location.href = "/cardapio";
    });

    document.addEventListener('click', (e) => {
      if(!e.target.closest('.search-container')) sugestoesEl.innerHTML = '';
    });

    // ===== SUGESTÕES CARDS =====
    const itensCardapio = [
      { nome: "Tricolor", preco: "R$ 20,00", descricao: "Espeto de linguiça uruguaia com cubos de frango e chimichurri." },
      { nome: "Laçador", preco: "R$ 25,00", descricao: "Espeto de cubos de picanha com queijo coalho (acompanha farofa e maionese)." },
      { nome: "Beira-rio", preco: "R$ 18,00", descricao: "Espeto de filet mignon suíno com tiras de bacon e geleia de pimenta." },
      { nome: "Gurizinho", preco: "R$ 10,00", descricao: "Espeto de carne simples." },
      { nome: "Chinelão", preco: "R$ 30,00", descricao: "Espeto completo de carne, frango, mignon suíno e bacon." },
      { nome: "Cidade Baixa", preco: "R$ 22,00", descricao: "Cubos de alcatra à milanesa (acompanha farofa e maionese)." },
      { nome: "Moinhos", preco: "R$ 20,00", descricao: "Espeto de carne, queijo provolone e bacon." },
      { nome: "Farrapos", preco: "R$ 18,00", descricao: "Espeto de cubos de frango com linguiça, calabresa e pimentões." },
      { nome: "Guaíba", preco: "R$ 25,00", descricao: "Cubos de tilápia com pimentões amarelos." },
      { nome: "Água", preco: "R$ 5,00", descricao: "Garrafa de água mineral gelada." },
      { nome: "Cerveja", preco: "R$ 15,00", descricao: "Cerveja artesanal ou tradicional." },
      { nome: "Refrigerante", preco: "R$ 9,00", descricao: "Lata de refrigerante gelado." },
      { nome: "Batata frita", preco: "R$ 15,00", descricao: "Porção crocante de batatas." },
      { nome: "Pão de alho", preco: "R$ 16,00", descricao: "Pão de alho assado com queijo." },
      { nome: "Pão de queijo", preco: "R$ 17,00", descricao: "Porção de pães de queijo quentinhos." },
      { nome: "Suco", preco: "R$ 15,00", descricao: "Suco natural de frutas." }
    ];

    const container = document.getElementById("sugestoes-container");

    function gerarSugestoes(){
      container.innerHTML = '';
      const sugestoesAtuais = [];
      while(sugestoesAtuais.length < 3){
        const aleatorio = itensCardapio[Math.floor(Math.random()*itensCardapio.length)];
        if(!sugestoesAtuais.some(s=>s.nome===aleatorio.nome)) sugestoesAtuais.push(aleatorio);
      }

      sugestoesAtuais.forEach(item=>{
        const card = document.createElement('div');
        card.className = 'card';
        card.innerHTML = `<h3>${item.nome}</h3>
                          <p>${item.descricao}</p>
                          <div class="preco">${item.preco}</div>
                          <button class="ir-cardapio">Ir ao cardápio</button>`;
        container.appendChild(card);
      });

      document.querySelectorAll('.ir-cardapio').forEach(btn=>{
        btn.addEventListener('click',()=>window.location.href='/cardapio');
      });
    }

    gerarSugestoes();
    setInterval(gerarSugestoes,10000);

  </script>

</body>
</html>
