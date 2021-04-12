@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb mt-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">Setting</li>
            <li class="breadcrumb-item active" aria-current="page">Items</li>
        </ol>
    </nav>

    <div class="row my-3">
        <div class="col-6 text-lg-left text-sm-center">
            <a href="{{ route('item.create') }}" class="btn btn-primary">Add Item</a>
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

    <table class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Price</th>
            <th>Category</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    <a href="{{ route('item.edit', ['item' => $item->id]) }}">
                        {{ $item->title }}
                    </a>
                </td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->category ? $item->category->name: '' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col-12">
            {{ $items->links() }}
        </div>
    </div>

@endsection
