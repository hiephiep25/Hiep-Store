<form action="shop">
    <div class="filter-widget">
        <h4 class="fw-title">Loại thực phẩm</h4>
        <ul class="filter-catagories">
            @foreach ($categories as $category)
                <li class="{{ $currentCategoryId == $category->id ? 'text-bold' : '' }}">
                    <a href="{{ url('shop/' . $category->id) }}">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="filter-widget">
        <h4 class="fw-title">Giá (nghìn VND)</h4>
        <div class="filter-range-wrap">
            <div class="range-slider">
                <div class="price-input">
                    <input type="text" id="minamount" name="price_min">
                    <input type="text" id="maxamount" name="price_max">
                </div>
            </div>
            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                data-min-value={{ request('price_min') }} data-max-value={{ request('price_max') }} data-min="5"
                data-max="1000">
                <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                <span tabindex="8" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                <span tabindex="8" class="ui-slider-handle ui-corner-all ui-state-default"></span>
            </div>
        </div>
        <button type="submit" class="filter-btn">Lọc</button>
    </div>
</form>
