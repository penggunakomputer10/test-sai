# Aplikasi Test SAI Menggunakan Laravel 9
- PHP Version Required 8

## Installation Instruction
```bash
git clone https://github.com/penggunakomputer10/test-sai.git
composer install
cp .env.example .env #Konfigurasi database
php artisan key:generate
php artisan migrate:fresh --seed
```