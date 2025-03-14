# Include file with .env variables if exists
-include .env

# Define default values for variables
COMPOSE_FILE ?= docker-compose.yml
BASE_IMAGE_DOCKERFILE ?= .docker/prod/base/Dockerfile
IMAGE_REGISTRY ?= prod
IMAGE_TAG ?= latest
PROJECT_NAME ?= "$(shell basename "$(realpath ../)")-api"
DC=docker compose -p ${PROJECT_NAME} -f ${COMPOSE_FILE}

#-----------------------------------------------------------
# Docker
#-----------------------------------------------------------

# Create shared gateway network
gateway:
	docker network create gateway

# Init variables for development environment
env.dev:
	cp .env.dev .env

# Init variables for development environment
env.stage:
	cp .env.stage .env

# Init variables for production environment
env.prod:
	cp .env.prod .env

# Build and start containers
bup: build.all up

# Start containers
up:
	${DC} up -d

# Stop containers
down:
	${DC} down --remove-orphans

# Build containers
build:
	${DC} build

# Build all containers
build.all: build.base build

# Build the base app image
build.base:
	docker build --file ${BASE_IMAGE_DOCKERFILE} --tag ${IMAGE_REGISTRY}/api-base:${IMAGE_TAG} .

# Show list of running containers
ps:
	${DC} ps

# Restart containers
restart:
	${DC} restart

# Reboot containers
reboot: down up

# View output logs from containers
logs:
	${DC} logs --tail 500

# Follow output logs from containers
logs.f:
	${DC} logs --tail 500 -f

#-----------------------------------------------------------
# Application
#-----------------------------------------------------------

# Enter the app container
bash:
	${DC} exec app /bin/bash

# Restart the app container
restart.app:
	${DC} restart app

# Alias to restart the app container
ra: restart.app

# Run the tinker service
tinker:
	${DC} exec app php artisan tinker

# Clear the app cache
cache.clear:
	${DC} exec app php artisan cache:clear

# Migrate the database
db.migrate:
	${DC} exec app php artisan migrate --force --no-interaction

# Alias to migrate the database
migrate: db.migrate

# Rollback the database
db.rollback:
	${DC} exec app php artisan migrate:rollback

# Seed the database
db.seed:
	${DC} exec app php artisan db:seed

# Fresh the database state
db.fresh:
	${DC} exec app php artisan migrate:fresh

# Refresh the database
db.refresh: db.fresh db.seed

# Dump database into file (only for development environment) (TODO: replace file name with env variable)
db.dump:
	${DC} exec mysql mysqldump -u ${DB_USERNAME} -p${DB_PASSWORD} ${DB_DATABASE} > ./.docker/dev/mysql/dumps/dump.sql

# Import database from file (only for development environment) (TODO: replace file name with env variable)
db.import:
	${DC} exec -T mysql mysql -u ${DB_USERNAME} -p${DB_PASSWORD} ${DB_DATABASE} < ./.docker/dev/mysql/dumps/import.sql

# Clear the database
db.drop:
	${DC} exec app php artisan db:wipe --force

# Clear the database and import the dump
db.import.clear: telescope.disable.app db.drop db.import telescope.enable.app db.migrate

# Create the database and grant privileges
db.grant:
	${DC} exec -T mysql mysql --protocol=socket -uroot -p${DB_PASSWORD} -e \
	"CREATE DATABASE IF NOT EXISTS ${DB_DATABASE}; \
	GRANT ALL PRIVILEGES ON *.* TO '${DB_USERNAME}'@'%';"

# Restart the queue process
queue.restart:
	${DC} exec queue php artisan queue:restart

# Install composer dependencies
composer.install:
	${DC} exec app composer install

# Install composer dependencies from stopped containers
r.composer.install:
	${DC} run --rm --no-deps app composer install

# Alias to install composer dependencies
ci: composer.install

# Update composer dependencies
composer.update:
	${DC} exec app composer update

# Update composer dependencies from stopped containers
r.composer.update:
	${DC} run --rm --no-deps app composer update

# Alias to update composer dependencies
cu: composer.update

# Show outdated composer dependencies
composer.outdated:
	${DC} exec app composer outdated

# PHP composer autoload command
composer.autoload:
	${DC} exec app composer dump-autoload

# Generate a symlink to the storage directory
storage.link:
	${DC} exec app php artisan storage:link --relative

# Give permissions of the storage folder to the www-data
storage.perm:
	sudo chmod -R 755 storage
	sudo chown -R www-data:www-data storage

# Give permissions of the storage folder to the current user
storage.perm.me:
	sudo chmod -R 755 storage
	sudo chown -R "$(shell id -u):$(shell id -g)" storage

# Give files ownership to the current user
own.me:
	sudo chown -R "$(shell id -u):$(shell id -g)" .


#-----------------------------------------------------------
# Testing (only for development environment)
#-----------------------------------------------------------

# Run phpunit tests (requires 'phpunit/phpunit' composer package)
test:
	${DC} exec app ./vendor/bin/phpunit --order-by=defects --stop-on-defect

# Alias to run phpunit tests
t: test

# Run phpunit tests with the coverage mode (TODO: install PCOV or other lib)
coverage:
	${DC} exec app ./vendor/bin/phpunit --coverage-html ./.coverage

# Run dusk tests (requires 'laravel/dusk' composer package)
dusk:
	${DC} exec app php artisan dusk

# Generate code metrics (requires 'phpmetrics/phpmetrics' composer package)
metrics:
	${DC} exec app ./vendor/bin/phpmetrics --report-html=./.metrics api/app

#-----------------------------------------------------------
# Redis
#-----------------------------------------------------------

# Enter the redis container
redis:
	${DC} exec redis redis-cli

# Flush the redis state
redis.flush:
	${DC} exec redis redis-cli FLUSHALL

#-----------------------------------------------------------
# Swarm
#-----------------------------------------------------------

# Deploy the stack
swarm.deploy:
	docker stack deploy --compose-file ${COMPOSE_FILE} api

# Remove/stop the stack
swarm.rm:
	docker stack rm api

# List of stack services
swarm.services:
	docker stack services api

# List the tasks in the stack
swarm.ps:
	docker stack ps api

# Init the Docker Swarm Leader node
swarm.init:
	docker swarm init
