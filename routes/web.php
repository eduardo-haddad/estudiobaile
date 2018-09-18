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

//Rotas padrão
Route::get('/', function () {
    return view('home');
});
Route::get('/admin', function () {
    return view('home');
});


// Rotas de autenticação (override em Auth::routes())

//Auth::routes();

// Login/Logout
$this->get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('admin/login', 'Auth\LoginController@login');
$this->post('admin/logout', 'Auth\LoginController@logout')->name('logout');

// Registrar
$this->get('admin/register', 'Auth\RegisterController@showRegistrationForm')->name('register')->middleware('isAdmin');
$this->post('admin/register', 'Auth\RegisterController@register');

// Senhas
$this->get('admin/password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->post('admin/password/reset', 'Auth\ResetPasswordController@reset');
$this->get('admin/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

//Rotas de admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'roles']], function(){ 

    // Permissões de usuário
    $padrao = ['administrador', 'usuario'];
    $admin = ['administrador'];
    $usuario = ['usuario'];

    // Ajax
    Route::get('/ajax/pf/index', [
        'uses' => 'PessoaFisicaController@ajaxIndex',
        'as' => 'ajax.pf.index',
        'roles' => $padrao
    ]);
    Route::get('/ajax/pf/atributos', [
        'uses' => 'PessoaFisicaController@ajaxAtributos',
        'as' => 'ajax.pf.create',
        'roles' => $padrao
    ]);
    Route::post('/ajax/pf/save', [
        'uses' => 'PessoaFisicaController@ajaxSave',
        'as' => 'ajax.pf.save',
        'roles' => $padrao
    ]);
    Route::get('/ajax/pf/{id}', [
        'uses' => 'PessoaFisicaController@ajaxView',
        'as' => 'ajax.pf.view',
        'roles' => $padrao
    ]);

    // Home
    Route::get('/home', [
        'uses' => 'HomeController@index',
        'as' => 'home',
        'roles' => $padrao
    ]);

    // Pessoas físicas
    Route::get('/pf/create', [
        'uses' => 'PessoaFisicaController@create',
        'as' => 'pf.create',
        'roles' => $padrao
    ]);
    Route::get('/pf/index', [
        'uses' => 'PessoaFisicaController@index',
        'as' => 'pf.index',
        'roles' => $padrao
    ]);
    Route::get('/pf/edit/dadosgerais/{id}', [
        'uses' => 'PessoaFisicaController@dadosGeraisEdit',
        'as' => 'pf.dadosgerais.edit',
        'roles' => $padrao
    ]);
    Route::post('/pf/update/dadosgerais/{id}', [
        'uses' => 'PessoaFisicaController@dadosGeraisUpdate',
        'as' => 'pf.dadosgerais.update',
        'roles' => $padrao
    ]);

    Route::post('/pf/store', [
        'uses' => 'PessoaFisicaController@store',
        'as' => 'pf.store',
        'roles' => $padrao
    ]);
    Route::get('/pf/view/{id}', [
        'uses' => 'PessoaFisicaController@view',
        'as' => 'pf.view',
        'roles' => $padrao
    ]);

    //Contatos - PF
    Route::get('/pf/create/contato/', [
        'uses' => 'ContatoController@create',
        'as' => 'pf.contatos.create',
        'roles' => $padrao
    ]);
    Route::get('/pf/edit/contato/{id}', [
        'uses' => 'ContatoController@edit',
        'as' => 'pf.contatos.edit',
        'roles' => $padrao
    ]);
    Route::post('/pf/update/contatos/{id}', [
        'uses' => 'ContatoController@update',
        'as' => 'pf.contatos.update',
        'roles' => $padrao
    ]);
    Route::post('/pf/store/contato/', [
        'uses' => 'ContatoController@store',
        'as' => 'pf.contatos.store',
        'roles' => $padrao
    ]);
    Route::delete('/pf/delete/contato/{id}', [
        'uses' => 'ContatoController@delete',
        'as' => 'pf.contatos.delete',
        'roles' => $padrao
    ]);

    
    // Posts
    Route::get('/post/create', [
        'uses' => 'PostsController@create',
        'as' => 'post.create',
        'roles' => $padrao
    ]);
    Route::post('/post/store', [
        'uses' => 'PostsController@store',
        'as' => 'post.store',
        'roles' => $padrao
    ]);

    // Categories
    Route::get('/categories', [
        'uses' => 'CategoriesController@index',
        'as' => 'categories',
        'roles' => $padrao
    ]);
    Route::get('/category/create', [
        'uses' => 'CategoriesController@create',
        'as' => 'category.create',
        'roles' => $padrao
    ]);
    Route::post('/category/store', [
        'uses' => 'CategoriesController@store',
        'as' => 'category.store',
        'roles' => $padrao
    ]);
    Route::get('/category/edit/{id}', [
        'uses' => 'CategoriesController@edit',
        'as' => 'category.edit',
        'roles' => $padrao
    ]);
    Route::get('/category/destroy/{id}', [
        'uses' => 'CategoriesController@destroy',
        'as' => 'category.destroy',
        'roles' => $padrao
    ]);
    Route::post('/category/update/{id}', [
        'uses' => 'CategoriesController@update',
        'as' => 'category.update',
        'roles' => $padrao
    ]);

});

