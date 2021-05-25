@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">Setting</li>
            <li class="breadcrumb-item active" aria-current="page">Items</li>
        </ol>
    </nav>

    <div class="row my-3">
        <div class="col-6 text-lg-left text-sm-center">
            <a href="{{ route('create-item-form') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-plus"></i> Add Item
            </a>
        </div>
        <div class="col-12 text-lg-right text-sm-center">
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
                <th>Created</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->created_at }}</td>
                <td>
                    <a href="{{ route('edit-item', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {!! $items->links() !!}

@endsection
