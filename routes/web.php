<?php

//Rotas padrão
Route::get('/', function () {
    return view('home');
})->name('home')->middleware('notLoggedIn');

//Site
Route::group(['prefix' => 'site'], function() {

    /*
     * Home
     */

    // View
    Route::view('/', 'site.home');
    // Ajax - lista Assunto
    Route::post('/assunto/index', ['uses' => 'SiteController@homeGetListaPf']);
    // Ajax - lista Lugar
    Route::post('/lugar/index', ['uses' => 'SiteController@homeGetListaPf']);
    // Ajax - lista Parceria
    Route::post('/parceria/index', ['uses' => 'SiteController@homeGetListaPf']);
    // Ajax - lista Pessoa
    Route::post('/pessoa/index', ['uses' => 'SiteController@homeGetListaPessoa']);
    Route::post('/pessoa/projetos/index', ['uses' => 'SiteController@homeGetListaPessoaProjetos']);

    /*
     * Projetos
     */
    Route::get('/projetoa', ['uses' => 'SiteController@projetoViewA']);

    Route::get('/projetob', ['uses' => 'SiteController@projetoViewB']);

    Route::get('/projetoc', ['uses' => 'SiteController@projetoViewc']);



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
$opcoes_rotas = [
    'middleware' => ['auth', 'roles'],
    'prefix' => ''
];

Route::group($opcoes_rotas, function(){

    // Permissões de usuário
    $superadmin = ['superadmin'];
    $admin = ['administrador'];
    $equipe = ['equipe'];
    $usuario = ['usuario'];

    $administradores = ['superadmin', 'administrador'];
    $interno = ['superadmin', 'administrador', 'equipe'];
    $geral = ['superadmin', 'administrador', 'equipe', 'usuario'];


    // Ajax

    // ** PESSOA FÍSICA **

    //Lista
    Route::get('/ajax/pf/index', [
        'uses' => 'PessoaFisicaController@ajaxIndex',
        'as' => 'ajax.pf.index',
        'roles' => $geral
    ]);
    //Criar
    Route::post('/ajax/pf/create', [
        'uses' => 'PessoaFisicaController@ajaxCreate',
        'as' => 'ajax.pf.create',
        'roles' => $geral
    ]);
    //View
    Route::get('/ajax/pf/{id}', [
        'uses' => 'PessoaFisicaController@ajaxView',
        'as' => 'ajax.pf.view',
        'roles' => $geral
    ]);
    //Atributos View
    Route::get('/ajax/pf/atributos', [
        'uses' => 'PessoaFisicaController@ajaxAtributos',
        'as' => 'ajax.pf.create',
        'roles' => $geral
    ]);
    //Salva formulário
    Route::post('/ajax/pf/save', [
        'uses' => 'PessoaFisicaController@ajaxSave',
        'as' => 'ajax.pf.save',
        'roles' => $geral
    ]);
    //Delete
    Route::post('/ajax/pf/delete', [
        'uses' => 'PessoaFisicaController@ajaxDelete',
        'as' => 'ajax.pf.delete',
        'roles' => $geral
    ]);
    //Contatos
    Route::post('/ajax/pf/addContato', [
        'uses' => 'PessoaFisicaController@ajaxAddContato',
        'as' => 'ajax.pf.addContato',
        'roles' => $geral
    ]);
    Route::post('/ajax/pf/removeContato', [
        'uses' => 'PessoaFisicaController@ajaxRemoveContato',
        'as' => 'ajax.pf.removeContato',
        'roles' => $geral
    ]);
    //Endereços
    Route::post('/ajax/pf/addEndereco', [
        'uses' => 'PessoaFisicaController@ajaxAddEndereco',
        'as' => 'ajax.pf.addEndereco',
        'roles' => $geral
    ]);
    Route::post('/ajax/pf/removeEndereco', [
        'uses' => 'PessoaFisicaController@ajaxRemoveEndereco',
        'as' => 'ajax.pf.removeEndereco',
        'roles' => $geral
    ]);
    //Dados bancários
    Route::post('/ajax/pf/addDadosBancarios', [
        'uses' => 'PessoaFisicaController@ajaxAddDadosBancarios',
        'as' => 'ajax.pf.addDadosBancarios',
        'roles' => $geral
    ]);
    Route::post('/ajax/pf/removeDadosBancarios', [
        'uses' => 'PessoaFisicaController@ajaxRemoveDadosBancarios',
        'as' => 'ajax.pf.removeDadosBancarios',
        'roles' => $geral
    ]);
    //Tags
    Route::get('/ajax/pf/getTags', [
        'uses' => 'PessoaFisicaController@ajaxGetTags',
        'as' => 'ajax.pf.getTags',
        'roles' => $geral
    ]);
    Route::get('/ajax/pf/getTagsSelecionadas/{id}', [
        'uses' => 'PessoaFisicaController@ajaxGetTagsSelecionadas',
        'as' => 'ajax.pf.getTagsSelecionadas',
        'roles' => $geral
    ]);
    //Cargos
    Route::post('/ajax/pf/ajaxAddCargoPj', [
        'uses' => 'PessoaFisicaController@ajaxAddCargoPj',
        'as' => 'ajax.pf.addChancelaPj',
        'roles' => $geral
    ]);
    Route::post('/ajax/pf/ajaxRemoveChancelaPj', [
        'uses' => 'PessoaFisicaController@ajaxRemoveChancelaPj',
        'as' => 'ajax.pf.removeChancelaPj',
        'roles' => $geral
    ]);
    //Generos
    Route::get('/ajax/pf/getGeneroSelecionado/{id}', [
        'uses' => 'PessoaFisicaController@ajaxGetGeneroSelecionado',
        'as' => 'ajax.pf.getGeneroSelecionado',
        'roles' => $geral
    ]);
    //Arquivos
    Route::post('/ajax/pf/upload', [
        'uses' => 'PessoaFisicaController@ajaxUpload',
        'as' => 'ajax.pf.upload',
        'roles' => $geral
    ]);
    Route::post('/ajax/pf/removeArquivo', [
        'uses' => 'PessoaFisicaController@ajaxRemoveArquivo',
        'as' => 'ajax.pf.removeArquivo',
        'roles' => $geral
    ]);
    //Imagem de destaque
    Route::post('/ajax/pf/getImagemDestaque', [
        'uses' => 'PessoaFisicaController@ajaxGetImagemDestaque',
        'as' => 'ajax.pf.ajaxGetImagemDestaque',
        'roles' => $geral
    ]);
    Route::post('/ajax/pf/setImagemDestaque', [
        'uses' => 'PessoaFisicaController@ajaxSetImagemDestaque',
        'as' => 'ajax.pf.setImagemDestaque',
        'roles' => $geral
    ]);
    //Projetos
    Route::get('/ajax/pf/getProjetosChancelasPorId/{id}', [
        'uses' => 'PessoaFisicaController@ajaxGetProjetosChancelasPorId',
        'as' => 'ajax.pf.getProjetosChancelasPorId',
        'roles' => $geral
    ]);
    Route::get('/export', [
        'uses' => 'Controller@exportPlanilha',
        'as' => 'exportPlanilha',
        'roles' => $geral
    ]);


    // ** PESSOA JURÍDICA **

    //Lista
    Route::get('/ajax/pj/index', [
        'uses' => 'PessoaJuridicaController@ajaxIndex',
        'as' => 'ajax.pj.index',
        'roles' => $geral
    ]);
    //Criar
    Route::post('/ajax/pj/create', [
        'uses' => 'PessoaJuridicaController@ajaxCreate',
        'as' => 'ajax.pj.create',
        'roles' => $geral
    ]);
    //View
    Route::get('/ajax/pj/{id}', [
        'uses' => 'PessoaJuridicaController@ajaxView',
        'as' => 'ajax.pj.view',
        'roles' => $geral
    ]);
    //Salva formulário
    Route::post('/ajax/pj/save', [
        'uses' => 'PessoaJuridicaController@ajaxSave',
        'as' => 'ajax.pj.save',
        'roles' => $geral
    ]);
    //Delete
    Route::post('/ajax/pj/delete', [
        'uses' => 'PessoaJuridicaController@ajaxDelete',
        'as' => 'ajax.pj.delete',
        'roles' => $geral
    ]);
    //Tags
    Route::get('/ajax/pj/getTagsSelecionadas/{id}', [
        'uses' => 'PessoaJuridicaController@ajaxGetTagsSelecionadas',
        'as' => 'ajax.pj.getTagsSelecionadas',
        'roles' => $geral
    ]);
    //Cargos
    Route::post('/ajax/pj/ajaxAddCargoPf', [
        'uses' => 'PessoaJuridicaController@ajaxAddCargoPf',
        'as' => 'ajax.pj.addCargoPf',
        'roles' => $geral
    ]);
    Route::post('/ajax/pj/ajaxRemoveCargoPf', [
        'uses' => 'PessoaJuridicaController@ajaxRemoveCargoPf',
        'as' => 'ajax.pj.removeCargoPf',
        'roles' => $geral
    ]);
    //Contatos
    Route::post('/ajax/pj/addContato', [
        'uses' => 'PessoaJuridicaController@ajaxAddContato',
        'as' => 'ajax.pj.addContato',
        'roles' => $geral
    ]);
    Route::post('/ajax/pj/removeContato', [
        'uses' => 'PessoaJuridicaController@ajaxRemoveContato',
        'as' => 'ajax.pj.removeContato',
        'roles' => $geral
    ]);
    //Endereços
    Route::post('/ajax/pj/addEndereco', [
        'uses' => 'PessoaJuridicaController@ajaxAddEndereco',
        'as' => 'ajax.pj.addEndereco',
        'roles' => $geral
    ]);
    Route::post('/ajax/pj/removeEndereco', [
        'uses' => 'PessoaJuridicaController@ajaxRemoveEndereco',
        'as' => 'ajax.pj.removeEndereco',
        'roles' => $geral
    ]);
    //Dados bancários
    Route::post('/ajax/pj/addDadosBancarios', [
        'uses' => 'PessoaJuridicaController@ajaxAddDadosBancarios',
        'as' => 'ajax.pj.addDadosBancarios',
        'roles' => $geral
    ]);
    Route::post('/ajax/pj/removeDadosBancarios', [
        'uses' => 'PessoaJuridicaController@ajaxRemoveDadosBancarios',
        'as' => 'ajax.pj.removeDadosBancarios',
        'roles' => $geral
    ]);
    //Arquivos
    Route::post('/ajax/pj/upload', [
        'uses' => 'PessoaJuridicaController@ajaxUpload',
        'as' => 'ajax.pj.upload',
        'roles' => $geral
    ]);
    Route::post('/ajax/pj/removeArquivo', [
        'uses' => 'PessoaJuridicaController@ajaxRemoveArquivo',
        'as' => 'ajax.pj.removeArquivo',
        'roles' => $geral
    ]);
    //Imagem de destaque
    Route::post('/ajax/pj/getImagemDestaque', [
        'uses' => 'PessoaJuridicaController@ajaxGetImagemDestaque',
        'as' => 'ajax.pj.ajaxGetImagemDestaque',
        'roles' => $geral
    ]);
    Route::post('/ajax/pj/setImagemDestaque', [
        'uses' => 'PessoaJuridicaController@ajaxSetImagemDestaque',
        'as' => 'ajax.pj.setImagemDestaque',
        'roles' => $geral
    ]);
    //Projetos
    Route::get('/ajax/pj/getProjetosChancelasPorId/{id}', [
        'uses' => 'PessoaJuridicaController@ajaxGetProjetosChancelasPorId',
        'as' => 'ajax.pj.getProjetosChancelasPorId',
        'roles' => $geral
    ]);

    // ** PROJETOS **

    //Lista
    Route::get('/ajax/projetos/index', [
        'uses' => 'ProjetoController@ajaxIndex',
        'as' => 'ajax.projetos.index',
        'roles' => $geral
    ]);
    //Criar
    Route::post('/ajax/projetos/create', [
        'uses' => 'ProjetoController@ajaxCreate',
        'as' => 'ajax.projetos.create',
        'roles' => $geral
    ]);
    //View
    Route::get('/ajax/projetos/{id}', [
        'uses' => 'ProjetoController@ajaxView',
        'as' => 'ajax.projetos.view',
        'roles' => $geral
    ]);
    //Salva formulário
    Route::post('/ajax/projetos/save', [
        'uses' => 'ProjetoController@ajaxSave',
        'as' => 'ajax.projetos.save',
        'roles' => $geral
    ]);
    //Delete
    Route::post('/ajax/projetos/delete', [
        'uses' => 'ProjetoController@ajaxDelete',
        'as' => 'ajax.projetos.delete',
        'roles' => $geral
    ]);
    //Pessoas físicas selecionadas
    Route::get('/ajax/projetos/getPfSelecionadas/{id}', [
        'uses' => 'ProjetoController@ajaxGetPfSelecionadas',
        'as' => 'ajax.projetos.getPfSelecionadas',
        'roles' => $geral
    ]);
    //Chancelas selecionadas
    Route::get('/ajax/projetos/getChancelasSelecionadas/{id}', [
        'uses' => 'ProjetoController@ajaxGetChancelasSelecionadas',
        'as' => 'ajax.projetos.ajaxGetChancelasSelecionadas',
        'roles' => $geral
    ]);
    Route::post('/ajax/projetos/ajaxAddChancela', [
        'uses' => 'ProjetoController@ajaxAddChancela',
        'as' => 'ajax.projetos.addChancelaPf',
        'roles' => $geral
    ]);
    Route::post('/ajax/projetos/ajaxRemoveChancela', [
        'uses' => 'ProjetoController@ajaxRemoveChancela',
        'as' => 'ajax.projetos.removeChancelaPf',
        'roles' => $geral
    ]);
    Route::post('/ajax/projetos/ajaxAddChancelaPj', [
        'uses' => 'ProjetoController@ajaxAddChancelaPj',
        'as' => 'ajax.projetos.addChancelaPj',
        'roles' => $geral
    ]);
    Route::post('/ajax/projetos/ajaxRemoveChancelaPj', [
        'uses' => 'ProjetoController@ajaxRemoveChancelaPj',
        'as' => 'ajax.projetos.removeChancelaPj',
        'roles' => $geral
    ]);
    //Arquivos
    Route::post('/ajax/projetos/upload', [
        'uses' => 'ProjetoController@ajaxUpload',
        'as' => 'ajax.projetos.upload',
        'roles' => $geral
    ]);
    Route::post('/ajax/projetos/removeArquivo', [
        'uses' => 'ProjetoController@ajaxRemoveArquivo',
        'as' => 'ajax.projetos.removeArquivo',
        'roles' => $geral
    ]);
    //Imagem de destaque
    Route::post('/ajax/projetos/getImagemDestaque', [
        'uses' => 'ProjetoController@ajaxGetImagemDestaque',
        'as' => 'ajax.projetos.ajaxGetImagemDestaque',
        'roles' => $geral
    ]);
    Route::post('/ajax/projetos/setImagemDestaque', [
        'uses' => 'ProjetoController@ajaxSetImagemDestaque',
        'as' => 'ajax.projetos.setImagemDestaque',
        'roles' => $geral
    ]);

    /** TAGS **/

    //Lista
    Route::get('/ajax/tags/index', [
        'uses' => 'TagController@ajaxIndex',
        'as' => 'ajax.tags.index',
        'roles' => $geral
    ]);
    //View
    Route::get('/ajax/tags/view/{id}', [
        'uses' => 'TagController@ajaxView',
        'as' => 'ajax.tags.view',
        'roles' => $geral
    ]);
    //Salva formulário
    Route::post('/ajax/tags/save', [
        'uses' => 'TagController@ajaxSave',
        'as' => 'ajax.tags.save',
        'roles' => $geral
    ]);
    //Remove cargo
    Route::post('/ajax/tags/ajaxRemoveCargo', [
        'uses' => 'TagController@ajaxRemoveCargo',
        'as' => 'ajax.tags.removeCargo',
        'roles' => $geral
    ]);
    //Remove chancela
    Route::post('/ajax/tags/ajaxRemoveChancela', [
        'uses' => 'TagController@ajaxRemoveChancela',
        'as' => 'ajax.tags.removeChancela',
        'roles' => $geral
    ]);
    //Remove tag
    Route::post('/ajax/tags/ajaxRemoveTag/{id}', [
        'uses' => 'TagController@ajaxRemoveTag',
        'as' => 'ajax.tags.removeTag',
        'roles' => $geral
    ]);
    //Remove tag
    Route::post('/ajax/tags/ajaxRemoveGenero/{id}', [
        'uses' => 'TagController@ajaxRemoveGenero',
        'as' => 'ajax.tags.removeGenero',
        'roles' => $geral
    ]);

    /** USUÁRIOS **/

    //Lista
    Route::get('/ajax/usuarios/index', [
        'uses' => 'UserController@ajaxIndex',
        'as' => 'ajax.usuarios.index',
        'roles' => $interno
    ]);
    //Criar
    Route::post('/ajax/usuarios/create', [
        'uses' => 'UserController@ajaxCreate',
        'as' => 'ajax.usuarios.create',
        'roles' => $interno
    ]);
    //Funções
    Route::get('/ajax/usuarios/funcoes', [
        'uses' => 'UserController@getFuncoes',
        'as' => 'ajax.usuarios.funcoes',
        'roles' => $interno
    ]);
    //Salva formulário
    Route::post('/ajax/usuarios/save', [
        'uses' => 'UserController@ajaxSave',
        'as' => 'ajax.usuarios.save',
        'roles' => $interno
    ]);
    //Remove usuário
    Route::post('/ajax/usuarios/removeUsuario/{id}', [
        'uses' => 'UserController@ajaxRemoveUsuario',
        'as' => 'ajax.usuarios.removeUsuario',
        'roles' => $interno
    ]);
    //Arquivos
    Route::post('/ajax/usuarios/upload', [
        'uses' => 'UserController@ajaxUpload',
        'as' => 'ajax.usuarios.upload',
        'roles' => $interno
    ]);
    Route::post('/ajax/usuarios/removeArquivo', [
        'uses' => 'UserController@ajaxRemoveArquivo',
        'as' => 'ajax.usuarios.removeArquivo',
        'roles' => $interno
    ]);
    //Imagem de destaque
    Route::post('/ajax/usuarios/getImagemDestaque', [
        'uses' => 'UserController@ajaxGetImagemDestaque',
        'as' => 'ajax.usuarios.ajaxGetImagemDestaque',
        'roles' => $interno
    ]);
    Route::post('/ajax/usuarios/setImagemDestaque', [
        'uses' => 'UserController@ajaxSetImagemDestaque',
        'as' => 'ajax.usuarios.setImagemDestaque',
        'roles' => $interno
    ]);
    //View
    Route::get('/ajax/usuarios/{id}', [
        'uses' => 'UserController@ajaxView',
        'as' => 'ajax.usuarios.view',
        'roles' => $interno
    ]);

    /** INTERNA **/
    Route::get('/ajax/interna/getInterna', [
        'uses' => 'InternaController@getInterna',
        'as' => 'ajax.interna.getInterna',
        'roles' => $interno
    ]);
    Route::post('/ajax/interna/saveInterna', [
        'uses' => 'InternaController@saveInterna',
        'as' => 'ajax.interna.saveInterna',
        'roles' => $interno
    ]);
    //Arquivos
    Route::post('/ajax/interna/upload', [
        'uses' => 'InternaController@ajaxUpload',
        'as' => 'ajax.interna.upload',
        'roles' => $interno
    ]);
    Route::post('/ajax/interna/removeArquivo', [
        'uses' => 'InternaController@ajaxRemoveArquivo',
        'as' => 'ajax.interna.removeArquivo',
        'roles' => $interno
    ]);

    /** GERAL **/
    Route::get('/download/{tipo}/{id}/{arquivo_id}', [
        'uses' => 'Controller@getFile',
        'roles' => $geral
    ]);


    // Home
    Route::get('/home', [
        'uses' => 'HomeController@index',
        'as' => 'home',
        'roles' => $geral
    ]);

    // Pessoas físicas
    Route::get('/pf/create', [
        'uses' => 'PessoaFisicaController@create',
        'as' => 'pf.create',
        'roles' => $geral
    ]);
    Route::get('/pf/index', [
        'uses' => 'PessoaFisicaController@index',
        'as' => 'pf.index',
        'roles' => $geral
    ]);
    Route::get('/pf/edit/dadosgerais/{id}', [
        'uses' => 'PessoaFisicaController@dadosGeraisEdit',
        'as' => 'pf.dadosgerais.edit',
        'roles' => $geral
    ]);
    Route::post('/pf/update/dadosgerais/{id}', [
        'uses' => 'PessoaFisicaController@dadosGeraisUpdate',
        'as' => 'pf.dadosgerais.update',
        'roles' => $geral
    ]);

    Route::post('/pf/store', [
        'uses' => 'PessoaFisicaController@store',
        'as' => 'pf.store',
        'roles' => $geral
    ]);
    Route::get('/pf/view/{id}', [
        'uses' => 'PessoaFisicaController@view',
        'as' => 'pf.view',
        'roles' => $geral
    ]);

    //Contatos - PF
    Route::get('/pf/create/contato/', [
        'uses' => 'ContatoController@create',
        'as' => 'pf.contatos.create',
        'roles' => $geral
    ]);
    Route::get('/pf/edit/contato/{id}', [
        'uses' => 'ContatoController@edit',
        'as' => 'pf.contatos.edit',
        'roles' => $geral
    ]);
    Route::post('/pf/update/contatos/{id}', [
        'uses' => 'ContatoController@update',
        'as' => 'pf.contatos.update',
        'roles' => $geral
    ]);
    Route::post('/pf/store/contato/', [
        'uses' => 'ContatoController@store',
        'as' => 'pf.contatos.store',
        'roles' => $geral
    ]);
    Route::delete('/pf/delete/contato/{id}', [
        'uses' => 'ContatoController@delete',
        'as' => 'pf.contatos.delete',
        'roles' => $geral
    ]);

    
    // Posts
    Route::get('/post/create', [
        'uses' => 'PostsController@create',
        'as' => 'post.create',
        'roles' => $geral
    ]);
    Route::post('/post/store', [
        'uses' => 'PostsController@store',
        'as' => 'post.store',
        'roles' => $geral
    ]);

    // Categories
    Route::get('/categories', [
        'uses' => 'CategoriesController@index',
        'as' => 'categories',
        'roles' => $geral
    ]);
    Route::get('/category/create', [
        'uses' => 'CategoriesController@create',
        'as' => 'category.create',
        'roles' => $geral
    ]);
    Route::post('/category/store', [
        'uses' => 'CategoriesController@store',
        'as' => 'category.store',
        'roles' => $geral
    ]);
    Route::get('/category/edit/{id}', [
        'uses' => 'CategoriesController@edit',
        'as' => 'category.edit',
        'roles' => $geral
    ]);
    Route::get('/category/destroy/{id}', [
        'uses' => 'CategoriesController@destroy',
        'as' => 'category.destroy',
        'roles' => $geral
    ]);
    Route::post('/category/update/{id}', [
        'uses' => 'CategoriesController@update',
        'as' => 'category.update',
        'roles' => $geral
    ]);

});
