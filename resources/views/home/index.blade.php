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

    <div class="row my-3">
        <div class="col-12">

            @foreach($categories as $category)
                <a href="{{ route('category-items', ['id' => $category->id]) }}"
                    class="btn btn-primary btn-sm">
                    {{ $category->name }}
                </a>
            @endforeach

        </div>
    </div>

    @include('partials.session-messages')

    @foreach(array_chunk($items->items(), 3) as $itemsCunk)
        <div class="row my-3">
            @foreach($itemsCunk as $item)
                <div class="col-4">
                    @include('home.partials.item', ['item' => $item])
                </div>
            @endforeach
        </div>
    @endforeach

    {{ $items->links() }}



@endsection
