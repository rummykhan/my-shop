@extends('layouts.app')

@section('title', 'Storefront')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">Categories</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
        </ol>
    </nav>

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
