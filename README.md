# Hiep-Store

### Nguồn tham khảo
#### tích hợp chatbot: https://github.com/patrickloeber/chatbot-deployment
#### giao diện mua hàng cho customer: https://www.youtube.com/playlist?list=PLsVJaIeVT78ozIMPtEbPHnXKNfC4UhZlW

## Hệ thống quản lí cửa hàng thực phẩm

### version:

#### php 8.1
#### laravel 10.10
#### vue 3.2.37
#### quasar 2.12.2

#### python 3.12.2

### công cụ xem db: laragon, dbeaver, xampp, ...
### IDE: vscode

### cách cài đặt:
    clone src code
    mở src code bằng vscode

    * ở trong thư mục laravel (cài đặt dự án laravel vuejs):
        - tạo terminal thứ nhất
            cd laravel
            composer install
            npm install
            cp .env.example .env (sau đó cấu hình lại file .env)
            mở laragon, hoặc dbevaer, xampp, tạo connection như trong file .env 
            php artisan key:generate
            php artisan migrate --seed (tạo db và seed dữ liệu)
            npm run dev
        - tạo terminal thứ hai
            php artisan serve

    * ở trong thư mục chatbot-api (cài đặt api cho chatbot):
        tạo terminal thứ ba
        cd chatbot-api
        python3 -m venv venv
        .\venv\Scripts\Activate.ps1 (trên window powershell)
        ở trong môi trường venv
            pip install Flask torch torchvision nltk
            python
            >>> import nltk
            >>> nltk.download('punkt')
            >>> quit() 
        ở môi trường venv
            python train.py
            pip install flask-cors
            pip install pyvi
            python app.py để chạy api chatbot

