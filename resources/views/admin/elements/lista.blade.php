<ul>
    @foreach($pessoas_fisicas as $pessoa)
        <li><a href="{{ route('pf.view', ['id' => $pessoa->id]) }}">{{ $pessoa->nome_adotado }}</a></li>
    @endforeach
</ul>
