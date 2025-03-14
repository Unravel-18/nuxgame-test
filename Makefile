# Start all containers
up:
	cd api; make up
	cd client; make up
	cd gateway; make up

# Stop all containers
down:
	cd api; make down
	cd client; make down
	cd gateway; make down

# Build and restart all containers
bre: build reboot

# Build all containers
build:
	cd api; make build.all
	cd client; make build

# Reboot all containers
reboot:
	cd api; make reboot
	cd client; make reboot
	cd gateway; make reboot

#----------------------------------------
# Deploy scripts
#----------------------------------------
live.deploy: build reboot migrate

stage.deploy: down build up migrate

migrate:
	cd api; sleep 5 && make migrate