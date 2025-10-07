<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CardapioController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\AdminController;

/// routes/web.php
Route::get('admin', [AdminController::class, 'index']);
Route::get('admin/novo_produto', [AdminController::class, 'novoProduto']);
Route::post('admin/novo_produto', [AdminController::class, 'salvarProduto']);
Route::get('admin/editar_produto/{id}', [AdminController::class, 'editarProduto']);
Route::put('admin/editar_produto/{id}', [AdminController::class, 'atualizarProduto']);
Route::delete('admin/deletar_produto/{id}', [AdminController::class, 'deletarProduto']);
Route::delete('admin/deletar_pedido/{id}', [AdminController::class, 'deletarPedido']);

// Finalizar pedido
Route::post('/pedido/finalizar', [PedidoController::class, 'finalizarPedido'])->name('pedido.finalizar');

// Página de sucesso
Route::get('/pedido/sucesso', [PedidoController::class, 'sucesso'])->name('pedido.sucesso');


Route::get('/cadastro', [RegisterController::class, 'create'])->name('register.form');
Route::post('/cadastro', [RegisterController::class, 'store'])->name('register.store');


// no topo já tem use... então só coloque abaixo das outras rotas:
Route::get('/', function () {
    return view('home'); // resources/views/home.blade.php
})->name('home');

// login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');

// logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// página do usuário - exige autenticação
Route::middleware('auth')->group(function () {
    Route::get('/usuario', [UsuarioController::class, 'index'])->name('usuario');

    // rotas adicionais do usuário (update foto, update phone, etc.)
    Route::post('/usuario/update-photo', [UsuarioController::class, 'updatePhoto'])->name('usuario.updatePhoto');
    Route::post('/usuario/remove-photo', [UsuarioController::class, 'removePhoto'])->name('usuario.removePhoto');

    Route::post('/usuario/update-user', [UsuarioController::class, 'updateUser'])->name('usuario.updateUser');
    Route::post('/usuario/update-password', [UsuarioController::class, 'updatePassword'])->name('usuario.updatePassword');
    Route::post('/usuario/update-phone', [UsuarioController::class, 'updatePhone'])->name('usuario.updatePhone');
    Route::post('/usuario/update-address', [UsuarioController::class, 'updateAddress'])->name('usuario.updateAddress');

    Route::post('/usuario/destroy', [UsuarioController::class, 'destroy'])->name('usuario.destroy');
});
// Cardápio
Route::get('/cardapio', [CardapioController::class, 'index'])->name('cardapio');
Route::post('/cardapio/adicionar', [CardapioController::class, 'adicionarCarrinho'])->name('cardapio.adicionar');

// Carrinho
Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho');
Route::post('/carrinho/remover', [CarrinhoController::class, 'remover'])->name('carrinho.remover');
Route::post('/carrinho/checkout', [CarrinhoController::class, 'checkout'])->name('carrinho.checkout');

Route::get('/pagamento', [PagamentoController::class, 'show'])->name('pagamento');
Route::post('/pagamento', [PagamentoController::class, 'confirmar'])->name('pagamento.confirmar');
Route::get('/pedido/sucesso', [PagamentoController::class, 'sucesso'])->name('pedido.sucesso');


Route::get('admin', [AdminController::class, 'index']);
Route::delete('admin/deletar_pedido/{id}', [AdminController::class, 'deletarPedido'])->name('admin.deletarPedido');

// Pedido
Route::get('/pagamento', [PedidoController::class, 'mostrarPagamento'])->name('pagamento');
Route::post('/pedido/finalizar', [PedidoController::class, 'finalizarPedido'])->name('pedido.finalizar');
Route::get('/pedido/sucesso', [PedidoController::class, 'sucesso'])->name('pedido.sucesso');