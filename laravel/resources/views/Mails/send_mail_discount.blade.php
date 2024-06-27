@component('mail::message')
# Ưu đãi giảm giá

Chúng tôi xin gửi đến bạn thông tin về chương trình khuyến mãi hiện tại từ {{ config('app.name') }}

## Thông tin chi tiết về khuyến mãi

**Tên khuyến mãi:** {{ $discount->name }}

<p style="color: brown; font-weight:bold">Mã khuyến mãi: {{ $discount->code }}</p>

**Mô tả:** {{ $discount->description }}

**Thời gian bắt đầu:** {{ $discount->start }}

**Thời gian kết thúc:** {{ $discount->end }}

@if ($discount->image)
**Hình ảnh:**
<br>
<img src="{{ asset($discount->image) }}" alt="{{ $discount->name }}" style="max-width: 100%; height: auto;">
@endif

## Các sản phẩm trong chương trình khuyến mãi:

@foreach ($discount->products as $product)
- **Tên sản phẩm:** {{ $product->name }}
  - **Mã sản phẩm:** {{ $product->code }}
  - **Giá trị khuyến mãi:** {{ $product->pivot->value }}
  - **Số lượng:** {{ $product->pivot->qty }}
@endforeach

Cảm ơn,<br>
{{ config('app.name') }}
@endcomponent
