# Heroku のデプロイ時に使用する Dockerfile

FROM php:8-apache

WORKDIR /var/www/html

# PHP で必要なライブラリをインストール
RUN apt-get update \
    && apt-get install -y libonig-dev libzip-dev unzip mariadb-client \
    && docker-php-ext-install pdo_mysql mysqli mbstring zip

# composer のインストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

# ファイルのコピー
COPY ./src /var/www/html
COPY ./docker/app/php.ini /usr/local/etc/php/php.ini

# Heroku で Apache2 が設定エラーになることへの対応
# https://github.com/docker-library/wordpress/issues/293
COPY ./docker/app/run-apache2.sh /usr/local/bin/
CMD [ "run-apache2.sh" ]
