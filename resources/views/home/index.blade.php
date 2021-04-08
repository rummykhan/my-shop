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

    <div class="row">
        <div class="col-6 text-lg-left text-sm-center">
            <a href="{{ route('create-item-form') }}" class="btn btn-primary">Add Item</a>
        </div>
        <div class="col-6 text-lg-right text-sm-center">
            <form action="{{ route('export-to-excel') }}" method="POST" style="display:inline-block;">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Export items to excel
                </button>
            </form>

            <form action="{{ route('export-to-csv') }}" method="POST" style="display:inline-block;">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-file-earmark-excel"></i> Export items to CSV
                </button>
            </form>

        </div>
    </div>


    @if(session()->has('success'))
        <div class="alert alert-success my-3" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif

    @foreach(array_chunk($items->items(), 3) as $itemsCunk)
        <div class="row my-3">
            @foreach($itemsCunk as $item)
                <div class="col-4">
                    @include('home.partials.item', ['item' => $item])
                </div>
            @endforeach
        </div>
    @endforeach



@endsection
