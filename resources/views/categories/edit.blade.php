@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
        </ol>
    </nav>

    @include('partials.session-messages')

    <form action="{{ route('category.update', ['category' => $category->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $category->name }}">
                </div>


                <div class="form-group mt-3">
                    <label for="">Image</label>
                    <input type="file" class="form-control img-upload" data-target="#img-thumbnail" name="image">
                </div>
            </div>


            <div class="col-6">
                <img src="{{ $category->image ? $category->getImageUrl() : asset('/images/placeholder.jpeg') }}" alt=""
                     id="img-thumbnail"
                     class="img-thumbnail">
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Update Category</button>
            </div>
        </div>


    </form>

@endsection
