@extends('layouts.app')
@section('content')
    <div class="container">
        <strong>{{$carts->count()}} Item(s) in shopping cart</strong>
        @forelse ($carts as $cart)
            <hr>
            <div class="row">
                <div class="col-sm-2">
                    <a href="{{route('products.show',$cart)}}">
                        <img src="{{url('products_photos/'.$cart->photo)}}" style="height: 100px" alt="">
                    </a>
                </div>
                <div class="col-sm">
                    <a href="{{route('products.show',$cart)}}">
                        {{$cart->name}}
                    </a>
                    <div class="row">
                        <div class="col-sm">
                            <small class="form-text text-muted">{{$cart->detail}}</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    {{$cart->price}} php
                </div>
                <div class="col-sm">
                    <a href="{{route('payments.create', $cart)}}" class="btn btn-outline-primary mb-2">Buy</a>
                    <form action="{{route('carts.store', $cart)}}" method="post">
                        @csrf
                        <button class="btn btn-outline-danger">{{auth()->user()->addedToCart($cart) ? 'Remove to cart' : 'Add to cart' }} </button>
                    </form>
                </div>
            </div>
            <hr>
        @empty
        <br>
        No Products put in cart yet. <a href="/">View Products</a>
        @endforelse
        {{ $carts->links() }}
    </div>
@endsection