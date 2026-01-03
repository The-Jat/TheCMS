@if (session('message'))
    <div class="alert alert-danger" role="alert">
        @if(is_array(session('message')))
            {{ session('message')['message'] }}
        @else
            {{ session('message') }}
        @endif
    </div>
@endif
@if(session()->has('errors'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif