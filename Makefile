
upc:
	export $(cat .env.docker | grep -v "^#" | xargs) && docker-compose up -d --build

downc:
	docker-compose down --volumes

rmi:
	docker image prune

rmc:
	docker rm $(docker ps -aq | xargs)