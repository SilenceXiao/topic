@foreach (['danger', 'warning', 'success', 'info'] as $msg)
<!-- {{ var_dump(session()) }} -->
  @if(session()->has($msg))
    <div class="flash-message">
      <p class="alert alert-{{ $msg }}">
        {{ session()->get($msg) }}
      </p>
    </div>
  @endif
@endforeach