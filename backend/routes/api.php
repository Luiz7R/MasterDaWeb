<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VendaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/registrar', [RegisterController::class, 'registrar']);

Route::prefix('v1')->middleware('jwt.auth')->group(function ($route) {
    $route->post('/logout', [AuthController::class, 'logout']);
    $route->get('/me', [AuthController::class, 'me']);
    $route->post('/refresh', [AuthController::class, 'refresh']);
});

Route::prefix('admin')->middleware('jwt.auth')->group(function ($route) {
    $route->get('/pedidos', [VendaController::class, 'pedidos']);
    $route->get('/produtosMaisVendidos', [VendaController::class, 'produtosMaisVendidos']);
    $route->get('/lucroProdutos', [VendaController::class, 'lucroProdutos']);
});

Route::get('/produtos', [ProdutosController::class, 'index'])->name('index');
Route::get('/pedidos', [PedidosController::class, 'index'])->name('index')->middleware('jwt.auth');

Route::group(['prefix' => 'carrinho', 'middleware' => 'jwt.auth'], function () {
    Route::get('', [CarrinhoController::class,'itensCarrinho'])->name('itensCarrinho');
    Route::post('', [CarrinhoController::class,'adicionarAoCarrinho'])->name('adicionarAoCarrinho');
    Route::patch('/{id}', [CarrinhoController::class,'atualizarProdutoNoCarrinho'])->name('atualizarProdutoNoCarrinho');
    Route::delete('/{id}', [CarrinhoController::class,'removerProdutoDoCarrinho'])->name('removerProdutoDoCarrinho');
});

Route::group(['prefix' => 'checkout', 'middleware' => 'jwt.auth'], function () {
    Route::get('/', [CheckoutController::class,'checkoutPage'])->name('checkoutPage');
    Route::post('/', [CheckoutController::class,'completeSale'])->name('postCheckout');
});
