@component('mail::message')
# Đặt lại mật khẩu

Nhấp vào nút bên dưới để đặt lại mật khẩu của bạn:

@component('mail::button', ['url' => $url])
Đặt lại mật khẩu
@endcomponent

Cảm ơn,<br>
{{ config('app.name') }}
@endcomponent
