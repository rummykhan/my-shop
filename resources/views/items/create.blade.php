@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Item</li>
        </ol>
    </nav>

    <form action="{{ route('create-item') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Title</label>
                    <input type="text" class="form-control" name="item_title">
                </div>

                <div class="form-group">
                    <label for="">Price</label>
                    <input type="number" class="form-control" name="item_price">
                </div>

                <div class="form-group mt-3">
                    <label for="">Image</label>
                    <input type="file" class="form-control img-upload" data-target="#img-thumbnail" name="item_image">
                </div>
            </div>


            <div class="col-6">
                <img src="{{ asset('/images/placeholder.jpeg') }}" alt="" id="img-thumbnail" class="img-thumbnail">
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Save Item</button>
            </div>
        </div>


    </form>

@endsection
