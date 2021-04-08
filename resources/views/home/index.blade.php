@extends('layouts.app')

@section('title', 'Storefront')

@section('content')

    <div class="col-md-10">
        <h2>My Online Shop</h2>
        <p>
            Welcome to My Shop! If you are looking for an item on jellybeans, this is the place to find information on
            it. Our database contains information on every item currently in existence on Neopets, including some items
            that have never been released!
        </p>
    </div>

    <a href="{{ route('create-item-form') }}" class="btn btn-primary">Add Item</a>

    @if(session()->has('success'))
        <div class="alert alert-success my-3" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif

    @foreach(array_chunk($items->items(), 3) as $itemsCunk)
        <div class="row my-3">
            @foreach($itemsCunk as $item)
                <div class="col-4">

                    <div class="card">
                        <div
                            style="background-image:url({{ $item->getImageUrl() }});background-size:cover;background-position:center top;height:140px;"
                            class="card-img-top"></div>
                        <div class="card-body">
                            <h5 class="card-title">$ {{ $item->price }}</h5>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($item->title, 20) }}</p>
                            <a href="{{ route('edit-item', ['id' => $item->id]) }}" class="btn btn-primary">Edit</a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endforeach



@endsection
