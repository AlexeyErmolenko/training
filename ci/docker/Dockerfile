FROM node:12-alpine as static-builder

# Add static sources, JS packages & versions lock file
WORKDIR /src
COPY package.json yarn.lock /src/

# 1. Install native packages, required to build NPM packages
# 2. Install NPM packages
# 3. Remove unnecessary native packages
# 4. Caches clean up
RUN apk add --no-cache --virtual .build-deps \
    git python g++ make file nasm autoconf zlib-dev &&\
    yarn install --non-interactive &&\
    apk del .build-deps &&\
    rm -rf /var/cache/apk/* &&\
    rm -rf /tmp/* &&\
    rm -rf /usr/local/share/.cache/yarn

COPY webpack.mix.js artisan .*rc /src/
COPY public public/
COPY resources/ resources/
COPY docs docs/

RUN npm run production &&\
    npx swagger-cli validate docs/API/index.yaml &&\
    npx swagger-cli bundle --type yaml --outfile public/swagger-ui/api.yaml docs/API/index.yaml


FROM training_start:base

### Install composer dependencies
COPY composer.* ./
RUN php -d sys_temp_dir=/tmp composer.phar global require --no-progress hirak/prestissimo
RUN php -d sys_temp_dir=/tmp composer.phar install \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --no-suggest \
    --no-scripts \
    --no-autoloader &&\
    rm -rf ${COMPOSER_HOME}

### Copy application files
COPY --from=static-builder /src/public public
COPY . /app

### Optimize Composer autoloader
RUN TELESCOPE_ENABLED=false php composer.phar install \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --no-suggest \
    --optimize-autoloader  &&\
    TELESCOPE_ENABLED=false php artisan down &&\
    TELESCOPE_ENABLED=false php artisan storage:link &&\
    TELESCOPE_ENABLED=false php artisan telescope:publish &&\
    chown -R nginx:nginx storage &&\
    nginx -T &&\
    php-fpm7 -t
