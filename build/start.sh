#!/bin/bash
set -e
PHP_SERVICE="php-fpm"

echo "Starting deployment..."
echo "Stopping containers..."
docker compose down
echo "Pulling latest code..."
git pull
echo "Starting containers..."
docker compose up --build -d
echo "Waiting for the container to be ready..."
while ! docker compose ps $PHP_SERVICE | grep -q 'Up'; do
  sleep 2
  echo "Waiting..."
done
echo "Installing dependencies..."
docker compose exec $PHP_SERVICE bash -c "composer install --no-progress"
docker compose exec $PHP_SERVICE bash -c "composer update --no-progress"
echo "Warming up Symfony cache..."
docker compose exec $PHP_SERVICE bash -c "bin/console cache:warmup"
echo "Running database migrations..."
docker compose exec $PHP_SERVICE bash -c "bin/console doctrine:migrations:migrate --no-interaction"
echo "Deployment completed successfully!"