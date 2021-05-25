@extends('layouts.app')

@section('title', 'Storefront')

@section('content')

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
