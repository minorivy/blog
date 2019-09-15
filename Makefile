
COMPOSE_FILE := docker-compose.production.yml

# Execute `eval $(make init)` as the "export" statement on Makefile dont work
init:
	export $$(cat .env.docker | grep -v "^#" | xargs) && export COMPOSE_FILE=$(COMPOSE_FILE)

upc:
	docker-compose up -d --build

downc:
	docker-compose down --volumes

rmi:
	docker image prune -f

rmc:
	docker rm $$(docker ps -aq | xargs)

opcache_reset:
	docker-compose exec php php -r "opcache_reset();"