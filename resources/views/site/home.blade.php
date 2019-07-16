@extends('site.layouts.base')
@section('conteudo')

<div class="row" id="banner">
  <div class="col ban-w">
    {{-- <img src="images/banner1.png"> --}}
  </div>
</div>
<div class="row" id="main">
  <div class="col-2">
    <div class="escolha bordarosa">
      <p>
        escolha por onde começar a busca de <a href="#">projetos</a>
      </p>
    </div>
  </div>
  <div class="col-2">
    <div class="bordarosa">
      <div class="num">
          1
      </div>
      <div class="mic-b">
        <ul class="lista" id="lista1">
          <li><a>assunto</a></li>
          <li><a>lugar</a></li>
          <li><a>parceria</a></li>
          <li><a>pessoa</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-2">
    <div class="bordarosa">
      <div class="num">
          2
      </div>
      <div class="mic-b">
        <ul class="lista" id="lista2">
          {{-- Assunto / Lugar / Parceria / Pessoa --}}
        </ul>
      </div>
    </div>
  </div>
  <div class="col-2">
      <div class="num">
          3
      </div>
      <div class="mic-b">
        <ul class="lista" id="lista3">
          {{-- Projetos --}}
        </ul>
      </div>
  </div>
</div>

@push('scripts')
<script>
  $(function(){

    $('#lista1 li a').on('click', function(e){
      // Desabilita comportamento padrão do link
      e.preventDefault();

      // Limpa dados a cada clique para não acumular
      $('#lista2').empty();
      $('#lista3').empty();

      // Assunto, lugar, parceria, pessoa
      let tipoLista = $(this).html();

      // Requisição ajax
      axios.post(`/site/${tipoLista}/index`)
        .then((response)=>{
          // Foreach em cada item
          $(response.data).each(function(){
            let item = $(this)[0];
            let lista2 = $('#lista2');
            // Adiciona uma linha para cada resultado vindo do BD
            switch(tipoLista) {
              case 'assunto':
                lista2.append(`<li><a class="lista2" data-tipo="pessoa" data-id="${item['id']}">${item['nome_adotado']}</a></li>`); break;
              case 'lugar':
                lista2.append(`<li><a class="lista2" data-tipo="pessoa" data-id="${item['id']}">${item['nome_adotado']}</a></li>`); break;
              case 'parceria':
                lista2.append(`<li><a class="lista2" data-tipo="pessoa" data-id="${item['id']}">${item['nome_adotado']}</a></li>`); break;
              case 'pessoa':
                lista2.append(`<li><a class="lista2" data-tipo="pessoa" data-id="${item['id']}">${item['nome_adotado']}</a></li>`); break;
            }
          });
        });

    });

    $('#lista2').on('click', '.lista2', function(){
      let id = $(this).data('id');
      let tipoLista = $(this).data('tipo');

      // Limpa dados a cada clique para não acumular
      $('#lista3').empty();

      // Requisição ajax
      axios.post(`/site/${tipoLista}/projetos/index`, {id: id})
        .then((response)=>{
          // Foreach em cada item
          $(response.data).each(function(){
            let item = $(this)[0];
            // Adiciona uma linha para cada resultado vindo do BD
            switch(tipoLista) {
              case 'pessoa':
                $('#lista3').append(`<li><a class="lista3" data-tipo="projeto" data-id="${item['id']}">${item['nome']}</a></li>`); break;
            }
          });
        });
    });

  });
</script>
@endpush

@stop