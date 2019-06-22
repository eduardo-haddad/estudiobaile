@extends('site.layouts.base')
@section('conteudo')

<div class="row" id="banner">
  <div class="col ban-w">
    {{-- <img src="images/banner1.png"> --}}
  </div>
</div>
<div class="row" id="main">
  <div class="col-2 esc">
    <p>
      escolha por onde começar a busca de <a href="">projetos</a>
    </p>
  </div>
  <div class="col-2 bep">
    <div class="num">
        1
    </div>
    <div class="mic-b">
      <ul class="lista" id="lista1">
        <li class="assunto"><a href="">assunto</a></li>
        <li class="lugar"><a href="">lugar</a></li>
        <li class="parceria"><a href="">parceria</a></li>
        <li class="pessoa"><a href="">pessoa</a></li>
      </ul>
    </div>
  </div>
  <div class="col-2 bep">
    <div class="num">
        2
    </div>
    <div class="mic-b">
      <ul class="lista" id="lista2">
        {{-- Nomes PF --}}
      </ul>
    </div>
  </div>
  <div class="col-2 bep">
    <div class="num">
        3
    </div>
    <div class="mic-b">
      <ul class="lista" id="lista3">

      </ul>
    </div>
  </div>
</div>

@push('scripts')
<script>
  $(document).ready(function(){
     $('#lista1 li a').on('click', function(e){

       e.preventDefault();

       // Se o pai do elemento clicado (li) tiver classe "pessoa"
       if($(this).parent().hasClass('pessoa')){

         // Requisição ajax para recuperar a lista de PF's no banco
         axios.post('/site/home/index/pf')
            .then((response)=>{
              // Iterar em cada item
              $(response.data).each(function(){
                let item = $(this)[0];
                let nome = item['nome'];
                let id = item['id'];
                $('#lista2').append(`<li><a data-id="${id}">${nome}</a></li>`);
              });
            }
         );
       }
     });
  });
</script>
@endpush

@stop