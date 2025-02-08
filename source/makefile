quick-start:
	docker compose up --build -d && docker compose exec php-cli composer install && docker compose exec php-cli php artisan migrate && docker compose exec php-cli php artisan db:seed

restart:
	docker compose down && docker compose up -d

rebuild:
	docker compose down && docker compose up --build -d

build:
	docker compose up -d --build

up:
	docker compose up -d

down:
	docker compose down

php:
	docker compose exec php-fpm bash

cli:
	docker compose exec php-cli bash

npm-install:
	docker compose exec node npm install

npm-dev:
	docker compose exec node npm run dev

npm-build:
	docker compose exec node npm run build

tinker:
	docker compose exec -u 0 php-cli php artisan tinker

test:
	docker compose exec php-fpm vendor/bin/phpunit

seed:
	docker compose exec php-fpm bin/console doctrine:schema:drop --full-database --force
	docker compose exec php-fpm bin/console doctrine:schema:create
	docker compose exec php-fpm bin/console doctrine:fixtures:load --group=AppFixtures --no-interaction

refresh:
	docker compose exec php-fpm bin/console doctrine:database:drop --force --if-exists
	docker compose exec php-fpm bin/console doctrine:database:create
	docker compose exec php-fpm bin/console doctrine:migrations:migrate --no-interaction
	docker compose exec php-fpm bin/console doctrine:fixtures:load --group=AppFixtures --no-interaction
