<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Novo Produto</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body { height: 678.5px}
        form { max-width: 500px; margin: 50px auto; background: #333; padding: 20px; border-radius: 10px; color: white; }
        input, textarea { width: 90%; padding: 10px; margin: 15px 0; border-radius: 6px; border: none; }
        button { padding: 10px 20px; background: orange; border: none; border-radius: 6px; color: white; cursor: pointer; }
        button:hover { background: darkorange; }
        .msg { text-align: center; padding: 10px; margin: 10px 0; border-radius: 6px; }
        .sucesso { background: #d4edda; color: #155724; }
        .erro { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1 style="text-align:center;">Adicionar Novo Produto</h1>

    @if(session('sucesso'))
        <div class="msg sucesso">{{ session('sucesso') }}</div>
    @endif
    @if(session('erro'))
        <div class="msg erro">{{ session('erro') }}</div>
    @endif

    <form action="{{ url('admin/novo_produto') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>Nome do Produto:</label>
    <input type="text" name="nome" required>

    <label>Descrição:</label>
    <textarea name="descricao" required></textarea>

    <label>Preço:</label>
    <input type="number" name="preco" step="0.01" min="0" required>

    <label>Categoria:</label>
    <select name="categoria" required>
        <option value="espetos">Espetos</option>
        <option value="acompanhamentos">Acompanhamentos</option>
        <option value="bebidas">Bebidas</option>
    </select>

    <label>Imagem:</label>
    <input type="file" name="imagem" accept="image/*">

    <button type="submit">Adicionar Produto</button>
</form>


    <div style="text-align:center">
        <a href="{{ url('admin') }}" style="color:white;background-color:orange;padding:20px;border-radius:20px">Voltar ao Painel Admin</a>
    </div>
</body>
</html>
