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
    Route::get('/pf', [
        'uses' => 'PessoaFisicaController@index',
        'as' => 'pf.index',
        'roles' => $padrao
    ]);
    Route::get('/pf/edit/{id}', [
        'uses' => 'PessoaFisicaController@edit',
        'as' => 'pf.edit',
        'roles' => $padrao
    ]);
    Route::post('/pf/update/{id}', [
        'uses' => 'PessoaFisicaController@update',
        'as' => 'pf.update',
        'roles' => $padrao
    ]);
    Route::post('/pf/store', [
        'uses' => 'PessoaFisicaController@store',
        'as' => 'pf.store',
        'roles' => $padrao
    ]);
    Route::get('/pf/{id}', [
        'uses' => 'PessoaFisicaController@view',
        'as' => 'pf.view',
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

