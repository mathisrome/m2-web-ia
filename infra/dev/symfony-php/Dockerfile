FROM php:8.3-fpm AS build

## Installation des utilitaires
RUN apt-get update && apt-get install -y curl vim nano git zip npm wkhtmltopdf
RUN npm install -g yarn


## Config Timezone
RUN rm /etc/localtime && ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime


## PHP Extensions & Composer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd exif pdo_mysql intl zip bcmath && install-php-extensions @composer

WORKDIR /var/www/api