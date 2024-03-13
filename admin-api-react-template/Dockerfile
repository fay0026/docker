ARG NODE_VERSION=21.7.1
ARG PHP_VERSION=8.1
ARG NGINX_VERSION=1.25.3

FROM node:${NODE_VERSION}-alpine as react_development

WORKDIR /usr/src/project

COPY package.json ./

COPY package-lock.json ./

RUN set -eux; \
    npm install

COPY . ./

VOLUME /usr/src/project/node_modules/

CMD ["npm start"]



FROM react_development as react_build

RUN set -eux; \
    npm run build



FROM nginx:${NGINX_VERSION}-alpine as react_nginx

COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d

WORKDIR /usr/src/admin

COPY --from=react_development /usr/src/project/build/ ./build

RUN set -eux \
    docker build --target react_development -t fay0026/demo-react:v1.0.0 .