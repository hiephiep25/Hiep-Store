# Hiep-Store
## Hệ thống quản lí cửa hàng thực phẩm

### version:
#### php 8.1
#### laravel 10.10
#### vue 3.2.37
#### quasar 2.12.2

### công cụ xem db: laragon, dbeaver, xampp, ...
### IDE: vscode

### cách cài đặt:
    clone src code
    mở src code bằng vscode
    composer install
    npm install
    cp .env.example .env (sau đó cấu hình lại file .env)
    mở laragon, hoặc dbevaer, xampp, tạo connection như trong file .env 
    php artisan key:generate
    php artisan migrate --seed (tạo db và seed dữ liệu)
    npm run dev
    php artisan serve để khởi động project trên trình duyệt

