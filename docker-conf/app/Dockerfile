FROM php:7.1-fpm

# Install nginx
RUN apt-key adv --keyserver hkp://pgp.mit.edu:80 --recv-keys 573BFD6B3D8FBC641079A6ABABF5BD827BD9BF62 \
    && echo "deb http://nginx.org/packages/mainline/debian/ jessie nginx" >> /etc/apt/sources.list \
    && apt-get update \
    && apt-get install --no-install-recommends --no-install-suggests -y \
        ca-certificates \
        nginx \
        nginx-module-xslt \
        nginx-module-geoip \
        nginx-module-image-filter \
        nginx-module-perl \
        nginx-module-njs \
        gettext-base \
	    apt-transport-https \
	    libpq-dev \
	    libmemcached-dev \
    && rm -rf /var/lib/apt/lists/*


RUN echo "deb http://ftp.debian.org/debian sid main" >> /etc/apt/sources.list \
    && apt-get update \
    && apt-get -y -t sid \
        install \
        libc6 \
        libc6-dev \
        libc6-dbg \
        unzip \
        vim \
        libzip-dev \
        php-zip \
        wget \
        autoconf \
        pkg-config \
        libssl-dev \
        gcc \
        g++ \
        build-essential \
        libxml2-dev \
        libcurl4-gnutls-dev \
        libexpat1-dev \
        libz-dev \
        git-all
# pecl
RUN pecl install zip xdebug memcached

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# phpunit
RUN wget https://phar.phpunit.de/phpunit-6.1.phar
RUN chmod +x phpunit-6.1.phar
RUN mv phpunit-6.1.phar /usr/local/bin/phpunit

# Set default workdir
ADD . /var/www/agenda
WORKDIR /var/www/agenda

# Declare some envs variables
ENV APPLICATION_ENV dev
ENV SERVER_NAME agenda.dev
ENV INDEX_FILE app_dev.php

# Install php libs
RUN docker-php-ext-install -j$(nproc) \
    bcmath \
    pdo \
    pdo_mysql \
    mbstring \
    dom \
    && docker-php-ext-enable zip xdebug memcached

RUN rm -rf /var/www/agenda/var/cache
RUN rm -rf /var/www/agenda/var/logs
RUN rm -rf /var/www/agenda/var/sessions

RUN mkdir /var/www/agenda/var/cache
RUN mkdir /var/www/agenda/var/logs
RUN mkdir /var/www/agenda/var/sessions

RUN chmod 777 -R /var/www/agenda/var/cache
RUN chmod 777 -R /var/www/agenda/var/logs
RUN chmod 777 -R /var/www/agenda/var/sessions

COPY docker-conf/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker-conf/nginx/default.conf /etc/nginx/conf.d/default.conf.template
COPY docker-conf/php/php.ini /etc/php.ini

#RUN composer install --no-interaction --optimize-autoloader

#RUN curl -sL https://deb.nodesource.com/setup_8.x | bash - \
#    && apt-get install --yes nodejs

#RUN npm install -g bower grunt-cli
#RUN bower install --allow-root

CMD /bin/bash -c "envsubst '\$SERVER_NAME \$INDEX_FILE \$APPLICATION_ENV' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/agenda.conf && nginx -g 'daemon off;'" & php-fpm

