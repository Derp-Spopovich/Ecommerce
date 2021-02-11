@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row">

        <div class="col-lg-3">

            <h1 class="my-4">Ecommerce</h1>
            <div class="list-group">
                <a href="{{route('products.index')}}" class="list-group-item">All</a>
                @foreach ($categories as $category)
                    <a href="{{route('products.index', ['category' => $category->name]) }}" class="list-group-item">{{$category->name}}</a>
                @endforeach
                
            </div>
            <div class="list-group mt-2">
                <p>Sort by price</p>
                <a href="{{route('products.index', ['category' => request()->category, 'sort' => 'low_high']) }}" class="list-group-item">low to high</a>
                <a href="{{route('products.index', ['category' => request()->category, 'sort' => 'high_low']) }}" class="list-group-item">high to low</a>
            </div>
           

        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

            <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                <img class="d-block img-fluid banner-img" src="{{url('/banner/banner3.jpg')}}" alt="First slide">
                </div>
                <div class="carousel-item">
                <img class="d-block img-fluid banner-img" src="{{url('/banner/banner4.jpg')}}" alt="Second slide">
                </div>
                <div class="carousel-item">
                <img class="d-block img-fluid banner-img" src="{{url('/banner/banner5.png')}}" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            </div>

            <div class="row">

            @forelse ($products as $product)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                    <a href="{{route('products.show', $product->id)}}"><img class="card-img-top" src="{{url('/products_photos/' .$product->photo)}}" style="height: 200px" alt=""></a>
                    <div class="card-body">
                        <h4 class="card-title">
                        <a href="{{route('products.show', $product->id)}}">{{$product->name}}</a>
                        </h4>
                        <h5>{{$product->price}} php</h5>
                        <p class="card-text">{{$product->detail}}</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                    </div>
                    </div>
                </div>
            @empty
                <div class="col-lg-4">
                    <p>No relevant products posted yet</p>
                </div>
            @endforelse

            {{ $products->appends(request()->input())->links() }} <!-- if theres already existing query string, it will not refresh. -->

            </div>
            <!-- /.row -->

        </div>
        <!-- /.col-lg-9 -->

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
@endsection