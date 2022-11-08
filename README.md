# Aplikasi Test SAI
- PHP Version Required 8

## Framework / Liblary Yang Digunakan
* Laravel Framework 9.38.0
* Admin Lte 
* Bootstrap
* Sweetalert
* Toastrjs
* Jquery

## Panduan Installasi
```bash
git clone https://github.com/penggunakomputer10/test-sai.git
composer install
cp .env.example .env #Konfigurasi database
php artisan key:generate
php artisan migrate:fresh --seed
```