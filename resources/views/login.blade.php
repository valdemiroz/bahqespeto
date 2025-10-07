<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Login - BahQEspetos</title>

  {{-- CSS principal --}}
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('img/bahqespeto.png') }}">
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body style="height:628.5px">

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
    <a href="{{ url('login') }}">
        <i class="fa fa-user" style="color:white;font-size:40px"></i>
        <p>usuário</p>
    </a>

    <div class="search-container" style="position:relative;">
        <input type="text" id="pesquisa" class="pesquisa" placeholder="Buscar item..." autocomplete="off" />
        <ul id="sugestoes" class="sugestoes"></ul>
    </div>
  </div>

  <!-- CONTEÚDO LOGIN -->
  <div class="usuario">
      <h2>Login</h2>

      {{-- Mensagens de erro --}}
      @if ($errors->any())
          <div class="errors" style="background:#900;padding:10px;border-radius:6px;margin-bottom:10px;">
              <ul>
                  @foreach ($errors->all() as $e)
                      <li>{{ $e }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      <form action="{{ route('login.attempt') }}" method="post" class="form-usuario">
          @csrf
          <label>Usuário:</label>
          <input type="text" name="usuario" value="{{ old('usuario') }}" required>

          <label>Senha:</label>
          <input type="password" name="senha" required><br><br>
          <button type="submit">Entrar</button>
          <a href="{{ route('register.form') }}" style="color:white; display:inline-block; margin-right:12px;">Não possui uma conta?</a>
      </form>
  </div>

  <div class="fim" style="text-align:center;padding:15px;background:rgb(45,45,45);margin-top:115px;color:white;">
      <p>©2025 BAHQESPETOS<br>
      Trazendo a cultura gaúcha com muito sabor<br>
      <a href="https://www.facebook.com" class="fa fa-facebook-official" style="color:white;font-size:32px"></a>
      <a href="https://www.instagram.com" class="fa fa-instagram" style="color:white;font-size:32px"></a><br><br>
      CNPJ: 10.978.458/0999-10<br>
      Av. Guilherme Schell, 478 - Canoas, RS
      </p>
  </div>

  {{-- SCRIPTS: menu e pesquisa (copie os scripts do home para o mesmo comportamento) --}}
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
  </script>
</body>
</html>
