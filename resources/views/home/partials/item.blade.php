<div class="card">
    <div
        style="background-image:url({{ $item->getImageUrl() }});background-size:cover;background-position:center top;height:140px;"
        class="card-img-top"></div>
    <div class="card-body">
        <h5 class="card-title">$ @item_price($item->price)</h5>

        <p class="card-text" style="min-height:2rem;">
            @item_title($item->title)
        </p>
        <a href="{{ route('edit-item', ['id' => $item->id]) }}" class="btn btn-primary">Edit</a>
    </div>
</div>
