FROM php:8.2-fpm-alpine
WORKDIR /home/www-data

## Installs Composer
RUN curl -sS https://getcomposer.org/installer \
    | php -- --filename=composer \
    --install-dir=/usr/local/bin

RUN mkdir -m777 /.composer \
    && mkdir -m777 /.config

## Installs extensions dependencies
RUN apk add --no-cache \
        postgresql-dev oniguruma-dev\
        curl-dev g++ autoconf make \
    && rm -rf /var/cache/apk/* \
    && find / -type f -iname \*.apk-new -delete \
    && rm -rf /var/cache/apk/*

# Installs needed extensions
RUN docker-php-ext-install -j$(nproc) pdo pdo_pgsql opcache mbstring

# Installs "default"? extensions
# RUN docker-php-ext-install -j$(nproc) bz2 calendar ctype exif gettext iconv intl phar posix shmop soap sockets sysvmsg sysvsem sysvshm tokenizer xml xmlwriter xsl wddx

# also "default", but with a weird issue: https://github.com/docker-library/php/issues/373
# RUN CFLAGS="-I/usr/src/php" docker-php-ext-install dom xmlreader

# probably needed/default but didn't work out of the box
RUN pecl install redis \
    && docker-php-ext-enable redis

# Those extensions are enabled by default, but they're here just for the sake of it
#RUN docker-php-ext-install curl ftp mysqlnd openssl sqlite3 zlib pdo_sqlite

# TODO: find a more elegant way to put composer dependency binaries in $PATH; 755 at /root so the other user can access binaries there
RUN chmod 755 /root \
    && ln -s /root/.composer/vendor/bin/* /usr/local/bin/

COPY conf/php-extras.ini /usr/local/etc/php/php-extras.ini
COPY conf/opcache.ini /usr/local/etc/php/conf.d/opcache.ini