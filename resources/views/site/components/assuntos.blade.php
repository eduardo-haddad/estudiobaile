<div class="campo">
  <p class="d-none d-md-block">assuntos</p>
  <span class="bold">
    @foreach ($tags as $tag)

      <p>
        {{ $tag }}
      </p>
        
    @endforeach
  </span>
</div>