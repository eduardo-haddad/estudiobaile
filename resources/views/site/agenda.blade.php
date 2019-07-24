@extends('site.layouts.base')
@section('conteudo')

<div class="row justify-content-center agenda formArea">
  <div class="col-md-1">
    <div class="interjeicao">
      <p class="bold">
        fique <br>
        por dentro!
      </p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="formulario">
      <form action="">
        <label for="nome">nome:</label>
        <input type="text" id="nome" name="nome"><br>

        <label for="email">email:</label>{{-- 
    --}}<input type="text" id="email" name="email"><br>
  
        <label for="ocup">ocupação:</label>{{-- 
    --}}<input type="text" id="ocup"  name="ocup"><br>
  
        <label for="cidade">cidade onde vive:</label>{{-- 
    --}}<input type="text" id="cidade" name="cidade">
  
        <div class="botao">
            <input type="submit" value="ok">
        </div>
      </form>
    </div>
  </div>
</div>
<div class="row justify-content-center agenda">
  agenda em si
</div>

@stop