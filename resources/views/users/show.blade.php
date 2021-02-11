@extends('layouts.app')
@section('content')
<main role="main">

    <section class="jumbotron text-center">
      <div class="container">
        <h1>{{ucwords($user->name)}}</h1>
        @if (empty($user->bio))
            <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
        @else
            <p class="lead text-muted">{{$user->bio}} </p>
        @endif
        
        <small>Joined {{$user->created_at->diffForHumans()}}</small>
        <br>
        <small>{{implode(',',$user->roles()->pluck('name')->toArray())}}</small>
        <p>
            @if (auth()->user()->is($user))
                <a href="{{route('users.edit', $user)}}" class="btn btn-secondary my-2">Edit Profile</a>
            @endif
        </p>
      </div>
    </section>
  
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">

                @forelse ($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="{{url('products_photos', $product->photo)}}" class="card-img-top" style="height: 200px" alt="">
            
                        <div class="card-body">
                        <p class="card-text">{{$product->name}}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="{{route('products.show', $product->id)}}"><button type="button" class="btn btn-sm btn-outline-secondary">View</button></a>
                                @auth
                                    @can('update', $product)
                                        <a href="{{route('products.edit', $product->id)}}"><button type="button" class="btn btn-sm btn-outline-secondary">Edit</button></a>
                                        <form action="{{route('products.destroy', $product->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    @endcan
                                @endauth
                            </div>
                            <small class="text-muted">{{$product->price}} php</small>
                        </div>
                        </div>
                    </div>
                </div>
                    
                @empty
                 <small> No products posted yet</small> 
                @endforelse

            </div>
        </div>
    </div>
@endsection