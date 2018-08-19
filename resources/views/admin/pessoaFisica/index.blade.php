@extends('layouts.app')

@section('content')

<ul>
    @foreach($pessoas_fisicas as $pessoa)
<li><a href="{{ route('pf.edit', ['id' => $pessoa->id]) }}">{{ $pessoa->nome_adotado }}</a></li>
    @endforeach
</ul>

@stop