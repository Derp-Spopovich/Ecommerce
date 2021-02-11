@if (session('success'))
    <div class="alert alert-success  alert-dismissible fade show container" role="alert">
        {{session('success')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('deleted'))
    <div class="alert alert-danger  alert-dismissible fade show container" role="alert">
        {{session('deleted')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif