FROM redis:5-alpine

ARG TIMEZONE

## disabling THP and altering TCP backlog setting doesn't work currently
# RUN echo 'sysctl -w net.core.somaxconn=65535' >> /etc/rc.local \
#	&& echo 'echo never > /sys/kernel/mm/transparent_hugepage/enabled' >> /etc/rc.local

RUN apk add --no-cache tzdata \
	&& cp /usr/share/zoneinfo/$TIMEZONE /etc/localtime \
	&& apk del tzdata \
	&& rm -rf /var/cache/apk/*

RUN test -d /usr/local/etc/redis || mkdir -p /usr/local/etc/redis
RUN touch /usr/local/etc/redis/redis.conf \
	&& echo 'bind 127.0.0.1 redis' >> /usr/local/etc/redis/redis.conf \
	&& chown -R redis /usr/local/etc/redis