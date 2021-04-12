<div class="card">
    <div
        style="background-image:url({{ $item->getImageUrl() }});
            background-size:5rem;
            background-repeat: no-repeat;
            background-position:center center;
            height:140px;"
        class="card-img-top"></div>
    <div class="card-body">
        <h5 class="card-title">$ {{ $item->price }}</h5>
        <p class="card-text" style="min-height:7rem;">{{ \Illuminate\Support\Str::limit($item->title, 80) }}</p>

        <div class="d-flex justify-content-end">
            <a href="#" class="btn btn-primary btn-sm pull-right">
                <i class="bi bi-cart-plus"></i> Add to Cart
            </a>
        </div>
    </div>
</div>
