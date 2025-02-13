ARG PHP_VERSION=8.1
ARG NGINX_VERSION=1.25.3


FROM php:${PHP_VERSION}-fpm-alpine as contacts_php

	ENV PATH="${PATH}:/root/.composer/vendor/bin"

	ENV COMPOSER_ALLOW_SUPERUSER = 1

	# persistent / runtime deps
	RUN apk add --no-cache \
		acl \
		fcgi \
		file \
		gettext \
	    ;

	ARG APCU_VERSION=5.1.21
	# Lance les commandes, avec -eux pour gérer les erreurs
	RUN set -eux; \
	  apk add --no-cache --virtual .build-deps \
	      $PHPIZE_DEPS \
	      icu-dev \
	      libzip-dev \
	  ; \
	  \
	  docker-php-ext-configure zip; \
	  docker-php-ext-install -j$(nproc) \
	      intl \
	      pdo_mysql \
	      zip \
	  ; \
	  pecl install \
	      apcu-${APCU_VERSION} \
	  ; \
	  pecl clear-cache; \
	  docker-php-ext-enable \
	      apcu \
	      opcache \
	  ; \
	  \
	  runDeps="$( \
	      scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
		  | tr ',' '\n' \
		  | sort -u \
		  | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	  )"; \
	  apk add --no-cache --virtual .api-phpexts-rundeps $runDeps; \
	  \
	  apk del .build-deps

	COPY --from=composer /usr/bin/composer /usr/bin/composer

	RUN ln -s $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

	COPY docker/php/conf.d/config.ini $PHP_INI_DIR/conf.d/config.ini

	RUN set -eux; \
	composer global config --no-plugins allow-plugins.symfony/flex true; \
	composer global require "symfony/flex" --prefer-dist --no-progress --classmap-authoritative; \
	composer clear-cache

	WORKDIR /srv/contacts

	ENTRYPOINT ["docker-entrypoint.sh"]
	CMD ["php-fpm"]

	COPY docker/php/docker-entrypoint.sh /usr/local/bin

	RUN chmod u+--x /usr/local/bin/docker-entrypoint.sh



FROM nginx:${NGINX_VERSION}-alpine as contacts_nginx

	COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d

	WORKDIR /srv/contacts/public



FROM contacts_php as contacts_php_prod

	COPY composer.json composer.lock symfony.lock ./

	RUN set -eux; \
	    	composer install --prefer-dist --no-dev --no-scripts --no-progress; \
	    	composer clear-cache

	COPY .env ./

	RUN composer dump-env prod

	COPY bin bin/
	COPY /config ./config
	COPY /migrations ./migrations
	COPY /public ./public
	COPY /src ./src
	COPY /templates ./templates

	RUN find config migrations public src templates -type d -exec chmod a+rx {} \;
	RUN find config migrations public src templates -type f -exec chmod a+r {} \;

	RUN set -eux; \
	mkdir -p var/cache var/log; \
	composer dump-autoload --classmap-authoritative --no-dev; \
	composer run-script --no-dev post-install-cmd; \
	chmod +x bin/console; sync

FROM contacts_nginx as contacts_nginx_prod
	
	COPY --from=contacts_php_prod /srv/contacts/public /srv/contacts/public



