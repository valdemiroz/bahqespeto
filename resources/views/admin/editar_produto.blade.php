<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {height: 750px}
        form { max-width: 500px; margin: 50px auto; background: #333; padding: 20px; border-radius: 10px; color: white; }
        input, textarea { width: 90%; padding: 10px; margin: 10px 0; border-radius: 6px; border: none; }
        button { padding: 10px 20px; background: orange; border: none; border-radius: 6px; color: white; cursor: pointer; }
        button:hover { background: darkorange; }
        .msg { text-align: center; padding: 10px; margin: 10px 0; border-radius: 6px; }
        .sucesso { background: #d4edda; color: #155724; }
        .erro { background: #f8d7da; color: #721c24; }
        img { max-width: 150px; display: block; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1 style="text-align:center;">Editar Produto</h1>

    @if(session('sucesso'))
        <div class="msg sucesso">{{ session('sucesso') }}</div>
    @endif
    @if(session('erro'))
        <div class="msg erro">{{ session('erro') }}</div>
    @endif

    <form action="{{ url('admin/editar_produto/'.$produto->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label>Nome do Produto:</label>
    <input type="text" name="nome" value="{{ $produto->nome }}" required>

    <label>Descrição:</label>
    <textarea name="descricao" required>{{ $produto->descricao }}</textarea>

    <label>Preço:</label>
    <input type="number" name="preco" step="0.01" min="0" value="{{ $produto->preco }}" required>

    <label>Categoria:</label>
    <select name="categoria" required>
        <option value="espetos" {{ $produto->categoria === 'espetos' ? 'selected' : '' }}>Espetos</option>
        <option value="acompanhamentos" {{ $produto->categoria === 'acompanhamentos' ? 'selected' : '' }}>Acompanhamentos</option>
        <option value="bebidas" {{ $produto->categoria === 'bebidas' ? 'selected' : '' }}>Bebidas</option>
    </select>

    <label>Imagem Atual:</label>
    @if($produto->imagem)
        <img src="{{ asset('img/' . $produto->imagem) }}" alt="{{ $produto->nome }}">
    @endif

    <label>Alterar Imagem:</label>
    <input type="file" name="imagem" accept="image/*">

    <button type="submit">Atualizar Produto</button>
</form>


    <div style="text-align:center;margin-top:20px;">
        <a href="{{ url('admin') }}" style="color:white;background-color:orange;padding:20px;border-radius:20px">Voltar ao Painel Admin</a>
    </div>
</body>
</html>
