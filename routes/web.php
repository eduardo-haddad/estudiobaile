<?php

//Rotas padrão
Route::get('/admin', function () {
    return view('home');
})->middleware('notLoggedIn');
//Route::get('/', function () {
//    return redirect('/admin');
//});
Route::get('/', function () {
    return redirect('login');
});

// Rotas de autenticação (override em Auth::routes())

//Auth::routes();

// Login/Logout
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registrar
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register')->middleware('isAdmin');
$this->post('register', 'Auth\RegisterController@register');

// Senhas
$this->get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

//Rotas de admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'roles']], function(){ 

    // Permissões de usuário
    $padrao = ['administrador', 'usuario'];
    $admin = ['administrador'];
    $usuario = ['usuario'];

    // Ajax

    // ** PESSOA FÍSICA **

    //Lista
    Route::get('/ajax/pf/index', [
        'uses' => 'PessoaFisicaController@ajaxIndex',
        'as' => 'ajax.pf.index',
        'roles' => $padrao
    ]);
    //Criar
    Route::post('/ajax/pf/create', [
        'uses' => 'PessoaFisicaController@ajaxCreate',
        'as' => 'ajax.pf.create',
        'roles' => $padrao
    ]);
    //View
    Route::get('/ajax/pf/{id}', [
        'uses' => 'PessoaFisicaController@ajaxView',
        'as' => 'ajax.pf.view',
        'roles' => $padrao
    ]);
    //Atributos View
    Route::get('/ajax/pf/atributos', [
        'uses' => 'PessoaFisicaController@ajaxAtributos',
        'as' => 'ajax.pf.create',
        'roles' => $padrao
    ]);
    //Salva formulário
    Route::post('/ajax/pf/save', [
        'uses' => 'PessoaFisicaController@ajaxSave',
        'as' => 'ajax.pf.save',
        'roles' => $padrao
    ]);
    //Contatos
    Route::post('/ajax/pf/addContato', [
        'uses' => 'PessoaFisicaController@ajaxAddContato',
        'as' => 'ajax.pf.addContato',
        'roles' => $padrao
    ]);
    Route::post('/ajax/pf/removeContato', [
        'uses' => 'PessoaFisicaController@ajaxRemoveContato',
        'as' => 'ajax.pf.removeContato',
        'roles' => $padrao
    ]);
    //Endereços
    Route::post('/ajax/pf/addEndereco', [
        'uses' => 'PessoaFisicaController@ajaxAddEndereco',
        'as' => 'ajax.pf.addEndereco',
        'roles' => $padrao
    ]);
    Route::post('/ajax/pf/removeEndereco', [
        'uses' => 'PessoaFisicaController@ajaxRemoveEndereco',
        'as' => 'ajax.pf.removeEndereco',
        'roles' => $padrao
    ]);
    //Dados bancários
    Route::post('/ajax/pf/addDadosBancarios', [
        'uses' => 'PessoaFisicaController@ajaxAddDadosBancarios',
        'as' => 'ajax.pf.addDadosBancarios',
        'roles' => $padrao
    ]);
    Route::post('/ajax/pf/removeDadosBancarios', [
        'uses' => 'PessoaFisicaController@ajaxRemoveDadosBancarios',
        'as' => 'ajax.pf.removeDadosBancarios',
        'roles' => $padrao
    ]);
    //Tags
    Route::get('/ajax/pf/getTags', [
        'uses' => 'PessoaFisicaController@ajaxGetTags',
        'as' => 'ajax.pf.getTags',
        'roles' => $padrao
    ]);
    Route::get('/ajax/pf/getTagsSelecionadas/{id}', [
        'uses' => 'PessoaFisicaController@ajaxGetTagsSelecionadas',
        'as' => 'ajax.pf.getTagsSelecionadas',
        'roles' => $padrao
    ]);
    //Arquivos
    Route::post('/ajax/pf/upload', [
        'uses' => 'PessoaFisicaController@ajaxUpload',
        'as' => 'ajax.pf.upload',
        'roles' => $padrao
    ]);
    Route::post('/ajax/pf/removeArquivo', [
        'uses' => 'PessoaFisicaController@ajaxRemoveArquivo',
        'as' => 'ajax.pf.removeArquivo',
        'roles' => $padrao
    ]);
    //Imagem de destaque
    Route::post('/ajax/pf/getImagemDestaque', [
        'uses' => 'PessoaFisicaController@ajaxGetImagemDestaque',
        'as' => 'ajax.pf.ajaxGetImagemDestaque',
        'roles' => $padrao
    ]);
    Route::post('/ajax/pf/setImagemDestaque', [
        'uses' => 'PessoaFisicaController@ajaxSetImagemDestaque',
        'as' => 'ajax.pf.setImagemDestaque',
        'roles' => $padrao
    ]);


    // ** PESSOA JURÍDICA **

    //Lista
    Route::get('/ajax/pj/index', [
        'uses' => 'PessoaJuridicaController@ajaxIndex',
        'as' => 'ajax.pj.index',
        'roles' => $padrao
    ]);
    //Criar
    Route::post('/ajax/pj/create', [
        'uses' => 'PessoaJuridicaController@ajaxCreate',
        'as' => 'ajax.pj.create',
        'roles' => $padrao
    ]);
    //View
    Route::get('/ajax/pj/{id}', [
        'uses' => 'PessoaJuridicaController@ajaxView',
        'as' => 'ajax.pj.view',
        'roles' => $padrao
    ]);
    //Salva formulário
    Route::post('/ajax/pj/save', [
        'uses' => 'PessoaJuridicaController@ajaxSave',
        'as' => 'ajax.pj.save',
        'roles' => $padrao
    ]);
    //Tags
    Route::get('/ajax/pj/getTagsSelecionadas/{id}', [
        'uses' => 'PessoaJuridicaController@ajaxGetTagsSelecionadas',
        'as' => 'ajax.pj.getTagsSelecionadas',
        'roles' => $padrao
    ]);
    //Cargos
    Route::post('/ajax/pj/ajaxAddCargoPf', [
        'uses' => 'PessoaJuridicaController@ajaxAddCargoPf',
        'as' => 'ajax.pj.addCargoPf',
        'roles' => $padrao
    ]);
    Route::post('/ajax/pj/ajaxRemoveCargoPf', [
        'uses' => 'PessoaJuridicaController@ajaxRemoveCargoPf',
        'as' => 'ajax.pj.removeCargoPf',
        'roles' => $padrao
    ]);
    //Contatos
    Route::post('/ajax/pj/addContato', [
        'uses' => 'PessoaJuridicaController@ajaxAddContato',
        'as' => 'ajax.pj.addContato',
        'roles' => $padrao
    ]);
    Route::post('/ajax/pj/removeContato', [
        'uses' => 'PessoaJuridicaController@ajaxRemoveContato',
        'as' => 'ajax.pj.removeContato',
        'roles' => $padrao
    ]);
    //Endereços
    Route::post('/ajax/pj/addEndereco', [
        'uses' => 'PessoaJuridicaController@ajaxAddEndereco',
        'as' => 'ajax.pj.addEndereco',
        'roles' => $padrao
    ]);
    Route::post('/ajax/pj/removeEndereco', [
        'uses' => 'PessoaJuridicaController@ajaxRemoveEndereco',
        'as' => 'ajax.pj.removeEndereco',
        'roles' => $padrao
    ]);
    //Dados bancários
    Route::post('/ajax/pj/addDadosBancarios', [
        'uses' => 'PessoaJuridicaController@ajaxAddDadosBancarios',
        'as' => 'ajax.pj.addDadosBancarios',
        'roles' => $padrao
    ]);
    Route::post('/ajax/pj/removeDadosBancarios', [
        'uses' => 'PessoaJuridicaController@ajaxRemoveDadosBancarios',
        'as' => 'ajax.pj.removeDadosBancarios',
        'roles' => $padrao
    ]);
    //Arquivos
    Route::post('/ajax/pj/upload', [
        'uses' => 'PessoaJuridicaController@ajaxUpload',
        'as' => 'ajax.pj.upload',
        'roles' => $padrao
    ]);
    Route::post('/ajax/pj/removeArquivo', [
        'uses' => 'PessoaJuridicaController@ajaxRemoveArquivo',
        'as' => 'ajax.pj.removeArquivo',
        'roles' => $padrao
    ]);
    //Imagem de destaque
    Route::post('/ajax/pj/getImagemDestaque', [
        'uses' => 'PessoaJuridicaController@ajaxGetImagemDestaque',
        'as' => 'ajax.pj.ajaxGetImagemDestaque',
        'roles' => $padrao
    ]);
    Route::post('/ajax/pj/setImagemDestaque', [
        'uses' => 'PessoaJuridicaController@ajaxSetImagemDestaque',
        'as' => 'ajax.pj.setImagemDestaque',
        'roles' => $padrao
    ]);

    // ** PROJETOS **

    //Lista
    Route::get('/ajax/projetos/index', [
        'uses' => 'ProjetoController@ajaxIndex',
        'as' => 'ajax.projetos.index',
        'roles' => $padrao
    ]);
    //Criar
    Route::post('/ajax/projetos/create', [
        'uses' => 'ProjetoController@ajaxCreate',
        'as' => 'ajax.projetos.create',
        'roles' => $padrao
    ]);
    //View
    Route::get('/ajax/projetos/{id}', [
        'uses' => 'ProjetoController@ajaxView',
        'as' => 'ajax.projetos.view',
        'roles' => $padrao
    ]);
    //Salva formulário
    Route::post('/ajax/projetos/save', [
        'uses' => 'ProjetoController@ajaxSave',
        'as' => 'ajax.projetos.save',
        'roles' => $padrao
    ]);
    //Pessoas físicas selecionadas
    Route::get('/ajax/projetos/getPfSelecionadas/{id}', [
        'uses' => 'ProjetoController@ajaxGetPfSelecionadas',
        'as' => 'ajax.projetos.getPfSelecionadas',
        'roles' => $padrao
    ]);
    //Chancelas selecionadas
    Route::get('/ajax/projetos/getChancelasSelecionadas/{id}', [
        'uses' => 'ProjetoController@ajaxGetChancelasSelecionadas',
        'as' => 'ajax.projetos.ajaxGetChancelasSelecionadas',
        'roles' => $padrao
    ]);
    Route::post('/ajax/projetos/ajaxAddChancelaPf', [
        'uses' => 'ProjetoController@ajaxAddChancelaPf',
        'as' => 'ajax.projetos.addChancelaPf',
        'roles' => $padrao
    ]);
    Route::post('/ajax/projetos/ajaxRemoveChancelaPf', [
        'uses' => 'ProjetoController@ajaxRemoveChancelaPf',
        'as' => 'ajax.projetos.removeChancelaPf',
        'roles' => $padrao
    ]);
    Route::post('/ajax/projetos/ajaxAddChancelaPj', [
        'uses' => 'ProjetoController@ajaxAddChancelaPj',
        'as' => 'ajax.projetos.addChancelaPj',
        'roles' => $padrao
    ]);
    Route::post('/ajax/projetos/ajaxRemoveChancelaPj', [
        'uses' => 'ProjetoController@ajaxRemoveChancelaPj',
        'as' => 'ajax.projetos.removeChancelaPj',
        'roles' => $padrao
    ]);
    //Arquivos
    Route::post('/ajax/projetos/upload', [
        'uses' => 'ProjetoController@ajaxUpload',
        'as' => 'ajax.projetos.upload',
        'roles' => $padrao
    ]);
    Route::post('/ajax/projetos/removeArquivo', [
        'uses' => 'ProjetoController@ajaxRemoveArquivo',
        'as' => 'ajax.projetos.removeArquivo',
        'roles' => $padrao
    ]);
    //Imagem de destaque
    Route::post('/ajax/projetos/getImagemDestaque', [
        'uses' => 'ProjetoController@ajaxGetImagemDestaque',
        'as' => 'ajax.projetos.ajaxGetImagemDestaque',
        'roles' => $padrao
    ]);
    Route::post('/ajax/projetos/setImagemDestaque', [
        'uses' => 'ProjetoController@ajaxSetImagemDestaque',
        'as' => 'ajax.projetos.setImagemDestaque',
        'roles' => $padrao
    ]);

    /** TAGS **/

    //Lista
    Route::get('/ajax/tags/index', [
        'uses' => 'TagController@ajaxIndex',
        'as' => 'ajax.tags.index',
        'roles' => $padrao
    ]);
    //View
    Route::get('/ajax/tags/{id}', [
        'uses' => 'TagController@ajaxView',
        'as' => 'ajax.tags.view',
        'roles' => $padrao
    ]);
    //Salva formulário
    Route::post('/ajax/tags/save', [
        'uses' => 'TagController@ajaxSave',
        'as' => 'ajax.tags.save',
        'roles' => $padrao
    ]);
    //Remove tag
    Route::post('/ajax/tags/ajaxRemoveTag/{id}', [
        'uses' => 'TagController@ajaxRemoveTag',
        'as' => 'ajax.tags.removeTag',
        'roles' => $padrao
    ]);


    /** GERAL **/
    Route::get('/download/{tipo}/{id}/{arquivo_id}', [
        'uses' => 'Controller@getFile',
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

