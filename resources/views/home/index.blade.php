@extends('layouts.app')

@section('title', 'Storefront')

@section('content')

    <div class="col-md-10 mt-3">
        <h2>My Online Shop</h2>
        <p>
            Welcome to My Shop! If you are looking for an item on jellybeans, this is the place to find information on
            it. Our database contains information on every item currently in existence on Neopets, including some items
            that have never been released!
        </p>
    </div>


    @if(session()->has('success'))
        <div class="alert alert-success my-3" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif


    <div class="row my-3">
        <div class="col-12 d-flex justify-content-center">
            @foreach($categories as $category)

                <a href="{{ route('category-items', ['id' => $category->id, 'slug' => \Illuminate\Support\Str::slug($category->name)]) }}"
                   class="inline-block d-flex flex-column text-center mx-2" style="width:5rem;">
                    <div
                        class="border"
                        style="background-image:url({{ $category->getImageUrl() }});
                            background-size: 4rem;
                            background-position: center center;
                            background-repeat:no-repeat;
                            height: 5rem;
                            width: 5rem;
                            border-radius:50%">
                    </div>

                    <span>{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
    </div>

    @foreach(array_chunk($items->items(), 3) as $itemsCunk)
        <div class="row my-3">
            @foreach($itemsCunk as $item)
                <div class="col-4">
                    @include('home.partials.item', ['item' => $item])
                </div>
            @endforeach
        </div>
    @endforeach


    <div class="row">
        <div class="col-12">
            {{ $items->links() }}
        </div>
    </div>

@endsection
