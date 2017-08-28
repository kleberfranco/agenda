FROM php:7.0-fpm

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
    && rm -rf /var/lib/apt/lists/*

RUN echo "deb http://ftp.debian.org/debian sid main" >> /etc/apt/sources.list && apt-get update

RUN ACCEPT_EULA=Y apt-get install -y --force-yes unixodbc-dev

RUN apt-get install -y libmcrypt-dev vim php-fpm php-xml git php-mysql php-cli php-curl php-mbstring

# enableing php-extensions
RUN docker-php-ext-install bcmath mcrypt mysqli pdo pdo_mysql

COPY docker-conf/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker-conf/nginx/default.conf /etc/nginx/conf.d/default.conf.template
COPY docker-conf/php/php-fpm.conf /etc/php/7.0/fpm/pool.d/www.conf
COPY docker-conf/php/php.ini /etc/php/7.0/fpm/php.ini

EXPOSE 80

ADD . /var/www/agenda
WORKDIR /var/www/agenda

RUN rm -rf /var/www/agenda/var/cache/*
RUN chmod 777 -R /var/www/agenda/var/cache
RUN chmod 777 -R /var/www/agenda/var/logs
RUN chmod 777 -R /var/www/agenda/var/sessions

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
RUN composer install --no-interaction --optimize-autoloader

RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -
RUN apt-get install -y nodejs
RUN npm install -g bower grunt-cli
RUN bower install --allow-root

ENV SYMFONY_ENV dev

CMD service php7.0-fpm start & /bin/bash -c "envsubst '\$ADM_SERVER_NAME \$APPLICATION_ENV' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf && nginx -g 'daemon off;'"