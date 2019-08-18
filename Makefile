.PHONY: upc

COMPOSE_FILE := docker-compose.production.yml

initc:
	@make _init

# Execute `eval $(make _init)` as the "export" statement on Makefile dont work
_init:
	export $$(cat .env.docker | grep -v "^#" | xargs) && export COMPOSE_FILE=$(COMPOSE_FILE)

upc:
	docker-compose up -d --build

downc:
	docker-compose down --volumes

rmi:
	docker image prune -f

rmc:
	docker rm $$(docker ps -aq | xargs)