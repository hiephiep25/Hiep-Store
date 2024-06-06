<div class="product-item item {{ $product->category_id }}">
    <div class="pi-pic">
        <img src="{{ $product->image }}" alt="{{ $product->name }}">
        <div class="icon"><i class="icon_heart_alt"></i></div>
        <ul>
            <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
            <li class="quick-view"><a href="shop/product/{{ $product->id }}">Chi tiết</a></li>
        </ul>
    </div>
    <div class="pi-text">
        <div class="category-name">{{ $product->description }}</div>
        <a href="">
            <h5>{{ $product->name }}</h5>
        </a>
        <div class="product-price">
            {{ $product->price }}
        </div>
    </div>
</div>
