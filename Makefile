
initc:
	export $$(cat .env.docker | grep -v "^#" | xargs)

upc:
	docker-compose up -d --build

downc:
	docker-compose down --volumes

rmi:
	docker image prune

rmc:
	docker rm $$(docker ps -aq | xargs)