#!/bin/bash
set -e
PHP_SERVICE="php-fpm"  # Используем имя сервиса из docker-compose.yml

echo "Starting deployment..."
echo "Stopping containers..."
docker compose down
echo "Pulling latest code..."
git pull
echo "Starting containers..."
docker compose -f docker-compose.prod.yml --env-file=.env.local up --build -d
echo "Waiting for the container to be ready..."
while ! docker compose ps $PHP_SERVICE | grep -q 'Up'; do
  sleep 2
  echo "Waiting..."
done
echo "Installing dependencies..."
docker compose exec $PHP_SERVICE bash -c "composer install --no-dev --no-progress"
echo "Warming up Symfony cache..."
docker compose exec $PHP_SERVICE bash -c "bin/console cache:warmup"
echo "Running database migrations..."
docker compose exec $PHP_SERVICE bash -c "bin/console doctrine:migrations:migrate --no-interaction"
echo "Deployment completed successfully!"