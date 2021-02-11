@extends('layouts.app')
@section('content')
<div class="container px-lg-5">
    <div class="row mx-lg-n5">
        <div class="col py-3 px-lg-5 border bg-light"> <!-- start of first row -->
            <div class="col-mb-4">
                <div class="card">
                  <img src="{{url('products_photos/'.$product->photo)}}" class="product-show">
                    <div class="card-body">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="card-text">
                            Price: {{$product->price}} php
                        </p>
                        <p class="card-text">
                            Details: {{$product->detail}}
                        </p>
                        <p class="card-text">
                            Category: <a href="{{route('products.index', ['category' => $product->category->name]) }}">{{$product->category->name}}</a>
                        </p>
                        <p class="card-text">
                            Seller: <a href="{{route('users.show', $product->user)}}">{{$product->user->name}}</a>
                        </p>
                    </div>
                    <div class="container">
                        <div class="row row-cols-2">
                            @guest
                                <p>Login to buy/cart products</p>
                            @else
                                <div class="col">
                                    @cannot('update', $product)
                                        <form action="{{route('carts.store', $product->id)}}" method="post">
                                            @csrf
                                            @if (auth()->user()->addedToCart($product)) {{--if the login user has already added the product to cart --}}
                                                <button class="btn btn-outline-danger">Remove to cart</button>
                                        @else
                                            <button class="btn btn-outline-success">Add to cart</button>
                                        @endif
                                            {{-- <button class="btn btn-danger">{{auth()->user()->addedToCart($product) ? 'Remove to cart' : 'Add to cart' }} </button> --}}
                                        </form>
                                </div>
                                <div class="col">
                                    <a href="{{route('payments.create',$product)}}"><button class="btn btn-outline-primary">Buy now</button></a>
                                </div>
                                @endcannot
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div> <!--end of first row -->
        <div class="col py-3 px-lg-5 border bg-light">{{-- start of 2nd row --}}
            <button type="button" class="btn btn-primary">
                Rating: <span class="badge badge-light">{{round($ratings->avg('rating'), 2)}}</span> <small>/5</small> <!--get the average rating of the product -->
            </button>
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Give Comment and rating
                            </button>
                        </h2>
                    </div>
                </div>
            
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        @guest
                            <a href="/login">Login</a> to give rating
                        @else
                        <form method="POST" action="{{route('ratings.store', $product->id)}}">
                            @csrf
                            <small class="form-text text-muted">Please dont be rude to the owner or other users</small>
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label>Comment</label>
                                    <input type="text" name="comment" value="{{ old('comment') }}" class="form-control">
                                    @error('comment')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                @cannot('update', $product)
                                    @cannot('seller-users')
                                        <div class="col-md-2">
                                            <label for="exampleFormControlSelect1">Rating</label>
                                            <select class="form-control" name="rating">
                                                <option></option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                    @endcannot
                                @endcannot
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        @endguest
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Comments and ratings
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse ($ratings as $rating)
                            <small>{{$rating->created_at->diffForHumans()}}</small>
                            <li class="list-group-item">{{$rating->user->name}} <small>said</small>:  {{$rating->comment}}
                                @if (!empty($rating->rating))
                                <code>{{$rating->rating}}star</code>
                                @endif
                                @if (auth()->user()->id === $rating->user->id)
                                    <form action="{{route('ratings.destroy',$rating->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="badge badge-danger">delete</button>
                                    </form>
                                @endif
                            </li>
                        @empty
                            No rating yet
                        @endforelse
                    </ul>
                </div>
            </div>
        </div> <!-- end of 2nd row -->
    </div>
</div>
@endsection