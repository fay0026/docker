ARG MODE_VERSION=20.11.1

ARG PHP_VERSION=8.1
ARG NGINX_VERSION=1.25.3

/working/fay0026/s4-docker/admin-api-react-template/package.json
/working/fay0026/s4-docker/admin-api-react-template/package-lock.json

FROM nodejs:{$MODE_VERSION}-alpine as admin_development

	ENV COMPOSER_ALLOW_SUPERUSER = 1

	ENV PATH="${PATH}:/usr/src/admin"

	COPY package.json ./

	COPY package-lock.json ./

	COPY README.md ./

	COPY src/App.js src/App.test.js src/index.js src/reportWebVitals.js src/setupTests.js ./src

	COPY public/index.html public/manifest.json public/robots.txt ./public

	COPY docker/nginx/conf.d/default.conf ./docker/nginx/conf.d

	WORKDIR ./node_modules/

	CMD ["npm start"]



FROM admin_development as admin_build

	ARG REACT_APP_API_ENTRYPOINT=



FROM nginx:${NGINX_VERSION}-alpine as admin_nginx

	COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d

	WORKDIR ./public

	COPY --from=admin_development build/ ./build/

	
FROM Dockerfile:{1.0.0} as fay0026/demo-admin-react

	REACT_APP_API_ENTRYPOINT=https://demo.api-platform.com