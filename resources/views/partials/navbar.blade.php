<nav class="navbar navbar-expand-lg navbar-light bg-light py-3">
    <a class="navbar-brand" href="{{ route('home') }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img">
            <title>Bootstrap</title>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z"
                  fill="currentColor"></path>
        </svg>

        {{ env('APP_NAME') }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @foreach(\App\Models\Category::all() as $category)
                        <a class="dropdown-item" href="{{ route('category-items', ['id' => $category->id]) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">

            @if(auth('seller')->check())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-gear"></i> {{ auth()->guard('seller')->user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('items-index') }}">
                            <i class="bi bi-box"></i> Items
                        </a>
                        <a class="dropdown-item" href="{{ route('category.index') }}">
                            <i class="bi bi-app"></i> Categories
                        </a>

                        <form action="{{ route('seller-logout') }}" method="POST" id="seller-logout-form">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="#"
                           onclick="if(confirm('Are you sure?')){$('#seller-logout-form').submit();}">
                            Logout
                        </a>
                    </div>
                </li>
            @endif

            @if(auth('customer')->check())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-gear"></i> {{ auth()->guard('customer')->user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <form action="{{ route('customer-logout') }}" method="POST" id="customer-logout-form">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="#"
                           onclick="if(confirm('Are you sure?')){$('#customer-logout-form').submit();}">
                            Logout
                        </a>
                    </div>
                </li>
            @endif

            @if(!auth('seller')->check() && !auth('customer')->check())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-gear"></i> Setting
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('customer-login') }}">
                            <i class="bi bi-user"></i> Customer Login
                        </a>
                        <a class="dropdown-item" href="{{ route('seller-login') }}">
                            <i class="bi bi-shop"></i> Seller Login
                        </a>

                    </div>
                </li>
            @endif
        </ul>
    </div>
</nav>
