FROM valian/docker-nginx-auto-ssl

RUN addgroup -g 1000 -S www-data \
	&& adduser -u 1000 -D -S -G www-data www-data