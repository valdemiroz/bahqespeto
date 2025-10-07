<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cardápio</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('img/bahqespeto.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body { background-color:#222; color:white; font-family:Arial, sans-serif; }
    .item { background-color:rgb(45, 45, 45); border: 2px solid orange; padding: 15px; margin: 10px; width: 280px; display: inline-block; vertical-align: top; text-align: center; border-radius: 10px; transition: transform 0.3s, box-shadow 0.3s; }
    .item:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(255,140,0,0.6); }
    .item h3 { margin: 0 0 10px; }
    .item button { background: orange; color: white; padding: 8px 15px; border: none; cursor: pointer; border-radius: 6px; }
    .item button:hover { background: darkorange; }
    .msg { background: #dff0d8; padding: 10px; border: 1px solid #3c763d; color: #3c763d; margin: 10px 0; border-radius: 6px; }
    .categoria-container { display:flex; flex-wrap:wrap; justify-content:center; padding:10px; border:2px dashed gray; border-radius:10px; margin-bottom:20px; }
    .categoria-titulo { width:100%; text-align:center; color:white;text-transform:uppercase;padding:20px; border-bottom:2px solid orange; margin-top:30px; }
    #filtro-categoria, #ordenar { padding:8px 10px; margin:0 10px 20px 0; border-radius:6px; border:none; }
    a#btn-carrinho { background-color:orange;padding:30px;border-radius:30px;color:white;border:none;margin:20px;font-weight:bold;z-index:1000;position:fixed;bottom:20px;left:20px; text-decoration:none; display:inline-block; text-align:center; }
    a#btn-carrinho:hover { background-color:darkorange; }
    .search-container { position:relative; display:inline-block; }
    .sugestoes { position:absolute; top:100%; left:0; right:0; background:white; color:black; list-style:none; margin:0; padding:0; max-height:150px; overflow-y:auto; border-radius:4px; display:none; z-index:10; }
    .sugestoes li { padding:5px 10px; cursor:pointer; }
    .sugestoes li:hover { background:orange; color:white; }
  </style>
</head>
<body>

<!-- Topo -->
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

  <div class="search-container">
    <input type="text" id="pesquisa" class="pesquisa" placeholder="Buscar item..." autocomplete="off" />
    <ul id="sugestoes" class="sugestoes"></ul>
  </div>

  <i class="fa fa-bars" id="menu-toggle"></i>
  <div id="sidebar">
    <span id="close-btn">&times;</span>
    <ul>
      <li><a href="{{ url('/cardapio') }}">Nosso cardápio</a></li>
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
      <li><a href="/">Voltar ao início</a></li>
    </ul>
  </div>

  <script>
    const menuToggle=document.getElementById('menu-toggle');
    const sidebar=document.getElementById('sidebar');
    const closeBtn=document.getElementById('close-btn');
    menuToggle.addEventListener('click',()=>{sidebar.style.display='block'; setTimeout(()=>{sidebar.classList.add('active');},10);});
    closeBtn.addEventListener('click',()=>{sidebar.classList.remove('active'); setTimeout(()=>{sidebar.style.display='none';},400);});
  </script>
</div>

<br><br><br><br><br><br>
<h1 style="text-align:center;text-transform:uppercase;">Bem vindo ao nosso cardápio!</h1>

@if(session('msg'))
  <div class="msg" id="flash-msg">{{ session('msg') }}</div>
@endif

<!-- Filtros -->
<div style="text-align:center; margin-bottom:20px;">
  <select id="filtro-categoria">
    <option value="all">Todas as categorias</option>
    @foreach($produtos as $categoria => $produtos_categoria)
      <option value="{{ $categoria }}">{{ $categoria }}</option>
    @endforeach
  </select>

  <select id="ordenar">
    <option value="nome-asc">Nome A-Z</option>
    <option value="nome-desc">Nome Z-A</option>
    <option value="preco-asc">Preço Crescente</option>
    <option value="preco-desc">Preço Decrescente</option>
  </select>
</div>

<div class="produtos-container" style="display:flex; flex-wrap:wrap; justify-content:center;">
@foreach($produtos as $categoria => $produtos_categoria)
  <h2 class="categoria-titulo">{{ $categoria }}</h2>
  <div class="categoria-container">
    @foreach($produtos_categoria as $produto)
      <div class="item" data-id="{{ $produto->id }}" data-nome="{{ $produto->nome }}" data-preco="{{ $produto->preco }}" data-categoria="{{ $produto->categoria }}">
        <img src="{{ asset('img/' . $produto->imagem) }}" alt="{{ $produto->nome }}" height="50px">
        <h3>{{ $produto->nome }}</h3>
        <p>{{ $produto->descricao }}</p>
        <p><b>R$: {{ number_format($produto->preco,2,',','.') }}</b></p>
        <form action="{{ route('cardapio.adicionar') }}" method="post">
          @csrf
          <input type="hidden" name="id" value="{{ $produto->id }}">
          <input type="hidden" name="produto" value="{{ $produto->nome }}">
          <input type="hidden" name="preco" value="{{ $produto->preco }}">
          <input type="number" name="quantidade" value="1" min="1"><br><br>
          <button type="submit">Adicionar</button>
        </form>
      </div>
    @endforeach
  </div>
@endforeach
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const flash = document.getElementById('flash-msg');
    if(flash){
        setTimeout(() => {
            flash.style.transition = 'opacity 0.5s ease, transform 0.3s ease';
            flash.style.opacity = '0';
            flash.style.transform = 'translateY(-8px)';
            setTimeout(() => flash.remove(), 600);
        }, 3000);
    }
});

const usuarioLogado = {{ auth()->check() ? 'true' : 'false' }};
const input = document.getElementById("pesquisa");
const sugestoes = document.getElementById("sugestoes");
const produtos = Array.from(document.querySelectorAll('.item'));
const categoriasContainer = Array.from(document.querySelectorAll('.categoria-container'));
const titulos = Array.from(document.querySelectorAll('.categoria-titulo'));
const filtroCategoria = document.getElementById('filtro-categoria');
const ordenarSelect = document.getElementById('ordenar');

const itens = produtos.map(p => p.dataset.nome);

function normalizar(str) {
    return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
}

// Bloqueio do carrinho se não logado
document.querySelectorAll('.item form').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (!usuarioLogado) {
            e.preventDefault();
            alert("Você precisa estar logado para adicionar ao carrinho!");
            window.location.href = "{{ url('/login') }}";
        }
    });
});

// Atualiza cardápio
function atualizarCardapio() {
    const valorPesquisa = normalizar(input.value.trim());
    const categoriaSelecionada = filtroCategoria.value;
    const ordem = ordenarSelect.value;

    categoriasContainer.forEach((cont, idx) => {
        const items = Array.from(cont.querySelectorAll('.item'));
        let temVisivel = false;

        items.forEach(item => {
            const nome = normalizar(item.dataset.nome);
            const mostrar = nome.includes(valorPesquisa) && (categoriaSelecionada === 'all' || item.dataset.categoria === categoriaSelecionada);
            item.style.display = mostrar ? 'inline-block' : 'none';
            if(mostrar) temVisivel = true;
        });

        const visiveis = items.filter(i => i.style.display !== 'none');
        visiveis.sort((a,b) => {
            switch(ordem){
                case 'nome-asc': return a.dataset.nome.localeCompare(b.dataset.nome);
                case 'nome-desc': return b.dataset.nome.localeCompare(a.dataset.nome);
                case 'preco-asc': return parseFloat(a.dataset.preco) - parseFloat(b.dataset.preco);
                case 'preco-desc': return parseFloat(b.dataset.preco) - parseFloat(a.dataset.preco);
            }
            return 0;
        });
        visiveis.forEach(i => cont.appendChild(i));

        titulos[idx].style.display = temVisivel ? 'block' : 'none';
        cont.style.display = temVisivel ? 'flex' : 'none';
    });
}

function mostrarSugestoes() {
    const valor = normalizar(input.value.trim());
    const listaFiltrada = itens.filter(i => normalizar(i).includes(valor));
    sugestoes.innerHTML = '';
    if(listaFiltrada.length > 0) sugestoes.style.display = 'block';
    else sugestoes.style.display = 'none';

    listaFiltrada.forEach(nome => {
        const li = document.createElement("li");
        li.textContent = nome;
        li.onclick = () => { input.value = nome; atualizarCardapio(); sugestoes.style.display='none'; };
        sugestoes.appendChild(li);
    });
}

input.addEventListener('input', () => { atualizarCardapio(); mostrarSugestoes(); });
input.addEventListener('focus', mostrarSugestoes);
document.addEventListener("click", e => { if(!e.target.closest(".search-container")) sugestoes.style.display = "none"; });
filtroCategoria.addEventListener('change', atualizarCardapio);
ordenarSelect.addEventListener('change', atualizarCardapio);

atualizarCardapio();
</script>

<a href="{{ route('carrinho') }}" id="btn-carrinho">Ir para o Carrinho</a>

<div class="fim">
    <p>©2025 BAHQESPETOS<br>
    Trazendo a cultura gaúcha com muito sabor!<br>
    <a href="https://www.facebook.com" class="fa fa-facebook-official" style="color:white;font-size:32px" aria-hidden="true"></a>
    <a href="https://www.instagram.com" class="fa fa-instagram" style="color:white;font-size:32px" aria-hidden="true"></a><br><br>
    CNPJ: 10.978.458/0999-10<br>
    Av. Guilherme Schell, 478 - Canoas, RS
    </p>
</div>

</body>
</html>
