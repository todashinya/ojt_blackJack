FROM php:8.1-apache-buster
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]
COPY ./php/php.ini /usr/local/etc/php/
COPY ./apache/*.conf /etc/apache2/sites-enabled/

COPY --from=composer:2.3 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
  apt-get -y install git libicu-dev libonig-dev libzip-dev unzip locales libjpeg-dev zlib1g-dev libpng-dev libfreetype6-dev libxslt-dev && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  locale-gen en_US.UTF-8 && \
  localedef -f UTF-8 -i en_US en_US.UTF-8 && \
  a2enmod rewrite && \
  docker-php-ext-install intl pdo_mysql mbstring zip bcmath exif xsl && \
  docker-php-ext-enable zip exif && \
  docker-php-ext-configure gd --with-freetype --with-jpeg && \
  docker-php-ext-install -j$(nproc) gd && \
  composer config -g process-timeout 3600 && \
  composer config -g repos.packagist composer https://packagist.org

#npm
# RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
# RUN apt-get install -y nodejs
# RUN npm install npm@latest -g

WORKDIR /var/www/html/backend