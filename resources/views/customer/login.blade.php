@extends('layouts.app')

@section('title', 'Storefront')

@section('content')

    <div class="row my-5">
        <div class="col-6 offset-lg-3">

            <div class="card">

                <div class="card-header">
                    Customer Login
                </div>

                <div class="card-body">

                    @include('partials.session-messages')

                    <form action="{{ route('customer-authenticate') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>


                    </form>
                </div>


            </div>


        </div>
    </div>

@endsection
