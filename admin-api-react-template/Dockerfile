ARG NODE_VERSION=21.7.1

ARG PHP_VERSION=8.1
ARG NGINX_VERSION=1.25.3

FROM nodejs:${NODE_VERSION}-alpine as react_development

	ENV COMPOSER_ALLOW_SUPERUSER = 1

	ENV PATH="${PATH}:/usr/src/project"

	COPY package.json ./

	COPY package-lock.json ./

	RUN set -eux; \
	composer install

	COPY README.md ./

	COPY src/App.js src/App.test.js src/index.js src/reportWebVitals.js src/setupTests.js ./src

	COPY public/index.html public/manifest.json public/robots.txt ./public

	COPY docker/nginx/conf.d/default.conf ./docker/nginx/conf.d

	WORKDIR ./node_modules/

	CMD ["npm start"]



FROM react_development as react_build

	RUN set -eux; \
	docker build --target react_devlopment -t fay0026/demo-react:v1.0.0 .



FROM nginx:${NGINX_VERSION}-alpine as react_nginx

	COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d

	WORKDIR ./public

	COPY --from=react_development build/ ./build/