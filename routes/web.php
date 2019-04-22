<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('/home');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* PRODUTO */
Route::get('/cadastrarProdutos', 'ProdutoControlador@create' )->name('produto_cadastro');
Route::get('/listarProdutos', 'ProdutoControlador@index' )->name('produto_listar');
Route::post('/salvarProduto', 'ProdutoControlador@store' )->name('produto_salvar');

Route::post('/editarProduto', 'ProdutoControlador@update' )->name('produto_editar');

/*FINAL PRODUTO*/


/*FORNECEDOR*/
Route::get('/cadastrarFornecedor', 'FornecedorControlador@create')->name('fornecedor_cadastro');
Route::get('/listarFornecedor', 'FornecedorControlador@index' )->name('fornecedor_listar');
Route::post('/salvarFornecedor', 'FornecedorControlador@store' )->name('fornecedor_salvar');
/*FINAL FORNECEDOR*/


/*PRODUTO E FORNECEDOR */

Route::get('/cadastrarProdutoFornecedor', 'produtoFornecedorControlador@create')->name('produtofornecedor_cadastro');
Route::get('/listarProdutoFornecedor', 'produtoFornecedorControlador@index' )->name('produtofornecedor_listar');
Route::post('/salvarProdutoFornecedor', 'produtoFornecedorControlador@store' )->name('produtofornecedor_salvar');



/* FINAL PRODUTO E FORNECEDOR */


/* VENDAS */

Route::get('/venda', 'ProdutoControlador@venda' )->name('venda_listar');
Route::post('/salvarVenda', 'ProdutoControlador@efetuar_venda' )->name('venda_efetuar');
Route::post('/cancelarVenda', 'ProdutoControlador@cancelar_venda' )->name('venda_cancelar');


/* FINAL VENDAS */





Route::get('/registrar', function () {
    return view('auth/register');
});
