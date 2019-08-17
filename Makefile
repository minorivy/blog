.PHONY: upc

# OS value is linux or macos
OS := linux
COMPOSE_FILE := docker-compose.production.yml

initc:
	@make _init
	@make _initconf

# Execute `eval $(make _init)` as the "export" statement on Makefile dont work
_init:
	export $$(cat .env.docker | grep -v "^#" | xargs) && export COMPOSE_FILE=$(COMPOSE_FILE)

_initconf:
ifeq ($(OS),linux)
	sed -i -e 's/\$$www_user/'"$${www_user}"'/g' ./docker/nginx/nginx.prod.conf \
	&& sed -i -e 's/\$$www_user/'"$${www_user}"'/g' ./docker/php/www.conf
else
	sed -i '' -e 's/\$$www_user/'"$${www_user}"'/g' ./docker/nginx/nginx.prod.conf \
	&& sed -i '' -e 's/\$$www_user/'"$${www_user}"'/g' ./docker/php/www.conf
endif

upc:
	docker-compose up -d --build

downc:
	docker-compose down --volumes

rmi:
	docker image prune -f

rmc:
	docker rm $$(docker ps -aq | xargs)