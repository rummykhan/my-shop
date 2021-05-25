@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Category</li>
        </ol>
    </nav>

    @include('partials.session-messages')

    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                </div>


                <div class="form-group mt-3">
                    <label for="">Image</label>
                    <input type="file" class="form-control img-upload" data-target="#img-thumbnail" name="image">
                </div>
            </div>


            <div class="col-6">
                <img src="{{ asset('/images/placeholder.jpeg') }}" alt=""
                     id="img-thumbnail"
                     class="img-thumbnail">
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Save Category</button>
            </div>
        </div>


    </form>

@endsection
