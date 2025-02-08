
<h1 align="center">Beneficium | Sleep 🖼️ </h1>
  <h3 align="center">Учет Сна</h3>

![LaravelGallery](https://github.com/WSG434/LaravelGallery/blob/master/preview.jpg?raw=true)

## 🚀 Stack

- PHP 8.3, Symfony 6.4
- MySQL 8.0, Redis
- Docker

## ⚡ Quick setup

1. Скачать проект `git clone https://github.com/WSG434/LaravelGallery.git`
2. Скопировать и запустить docker команды в терминале: 
	`docker compose up --build -d && docker compose exec php-cli composer install && docker compose exec php-cli php artisan migrate && docker compose exec php-cli php artisan db:seed`
3. Перейти в браузер по адресу `localhost:8080`
