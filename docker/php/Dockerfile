FROM php:7.2-fpm

# Install extensions
RUN apt-get update \
	&& apt-get install -y libicu-dev zip unzip curl zlib1g-dev libpng-dev vim procps git \
	&& docker-php-ext-install intl opcache \
	&& docker-php-ext-enable intl opcache \
	&& docker-php-ext-install pdo pdo_mysql mysqli\
	&& docker-php-ext-install mbstring \
	&& pecl install xdebug-2.7.1 \
	&& docker-php-ext-enable xdebug \
	&& docker-php-ext-install gd \
	&& apt-get clean && rm -rf /var/lib/apt/lists/*

# using variables
ARG www_user
ARG www_password
ARG server_name
ARG NODE_VERSION

ENV NVM_DIR $NVM_DIR

HEALTHCHECK --interval=5m --timeout=3s \
  CMD curl -f http://${server_name}:8080/ || exit 1

RUN useradd -ms /bin/bash -g www-data $www_user \
	&& echo "${www_user}:${www_password}" | chpasswd

RUN chown -R $www_user:www-data /var/www/ \
	&& chown -R $www_user:www-data /var/run/ \
	&& chown -R $www_user:www-data /var/log/

# Install composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer && \
	composer global require hirak/prestissimo

USER ${www_user}
WORKDIR /var/www/app

# install Nodejs
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.34.0/install.sh | bash
RUN export NVM_DIR=$HOME/.nvm && . $HOME/.nvm/nvm.sh \
	&& nvm install $NODE_VERSION \
	&& nvm use $NODE_VERSION

COPY ./.bashrc ~/.bashrc