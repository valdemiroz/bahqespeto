<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="{{ asset('img/bahqespeto.png') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Cadastro de conta</title>
</head>
<body>
  <div class="topo">
    <a href="{{ auth()->check() ? route('usuario') : route('login') }}">
      <i class="fa fa-user" style="color:white;font-size:40px"></i>
      <p>usuário</p>
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

  <div class="usuario">
    <h2>Cadastro de Usuário</h2>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('register.store') }}" method="POST" class="form-usuario">
      @csrf

      <label for="usuario">Nome completo:</label>
      <input type="text" id="usuario" name="usuario" value="{{ old('usuario') }}" required>

      <label for="telefone">Telefone:</label>
      <input type="tel" id="telefone" name="telefone" value="{{ old('telefone') }}" placeholder="(XX) XXXXX-XXXX" required>

      <label for="endereco">Endereço:</label>
      <input type="text" id="endereco" name="endereco" value="{{ old('endereco') }}" required>

      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" value="{{ old('email') }}" required>

      <label for="senha">Senha:</label>
      <input type="password" id="senha" name="senha" required>

      <label for="senha_confirmation">Confirme a senha:</label>
      <input type="password" id="senha_confirmation" name="senha_confirmation" required>

      <button type="submit">Cadastrar</button>
      <a href="{{ route('login') }}" style="color:white">Já possui uma conta?</a>
    </form>
  </div>

  <div class="fim">
    <p>©2025 BAHQESPETOS<br>
    Trazendo a cultura gaúcha com muito sabor<br>
    <a href="https://www.facebook.com" class="fa fa-facebook-official" style="color:white;font-size:32px" aria-hidden="true"></a>
    <a href="https://www.instagram.com" class="fa fa-instagram" style="color:white;font-size:32px" aria-hidden="true"></a><br><br>
    CNPJ: 10.978.458/0999-10<br>
    Av. Guilherme Schell, 478 - Canoas, RS
    </p>
  </div>

  <!-- scripts (mantive sua lógica JS, só verifique caminhos caso precise separar em arquivo) -->
  <script>
    const itens = [
      "Tricolor", "Laçador", "Beira-rio", "Gurizinho", "Chinelão", "Cidade Baixa",
      "Moinhos", "Farrapos", "Guaíba", "Água", "Cerveja", "Refrigerante",
      "Batata frita", "Pão de alho", "Pão de queijo"
    ];

    const input = document.getElementById("pesquisa");
    const sugestoes = document.getElementById("sugestoes");

    function mostrarSugestoes(lista) {
      sugestoes.innerHTML = "";
      lista.forEach(item => {
        const li = document.createElement("li");
        li.textContent = item;
        li.onclick = () => {
          input.value = item;
          sugestoes.innerHTML = "";
        };
        sugestoes.appendChild(li);
      });
    }

    input.addEventListener("focus", () => {
      mostrarSugestoes(itens);
    });

    input.addEventListener("input", () => {
      const valor = input.value.trim().toLowerCase();
      if (valor.length === 0) {
        mostrarSugestoes(itens);
        return;
      }
      const filtrados = itens.filter(item => item.toLowerCase().startsWith(valor));
      mostrarSugestoes(filtrados);
    });

    input.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        e.preventDefault();
        const valor = input.value.trim().toLowerCase();

        if (valor === "admin") {
          acessarAdmin();
          return;
        }

        const encontrado = itens.find(item => item.toLowerCase() === valor);
        // aqui redirecione para a rota cardapio (URL gerada pelo Laravel)
        if (encontrado) {
          window.location.href = "{{ route('cardapio') }}";
        } else {
          alert("Tente acessar o nosso cardápio! aguarde em instantes...");
          window.location.href = "{{ route('cardapio') }}";
        }
      }
    });


    document.addEventListener("click", (e) => {
      if (!e.target.closest(".search-container")) {
        sugestoes.innerHTML = "";
      }
    });

    // menu toggle
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const closeBtn = document.getElementById('close-btn');

    menuToggle?.addEventListener('click', () => {
      sidebar.style.display = 'block';
      setTimeout(() => { sidebar.classList.add('active'); }, 10);
    });

    closeBtn?.addEventListener('click', () => {
      sidebar.classList.remove('active');
      setTimeout(() => { sidebar.style.display = 'none'; }, 400);
    });
  </script>
</body>
</html>
