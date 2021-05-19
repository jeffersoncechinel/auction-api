FROM php:7.3.6-fpm-alpine3.9

RUN apk add --no-cache shadow openssl bash mysql-client nodejs npm git supervisor
RUN docker-php-ext-install pdo pdo_mysql

RUN mkdir -p /usr/src/php/ext \
    && cd /usr/src/php/ext \
    && pecl bundle igbinary \
    && docker-php-ext-configure igbinary \
    && docker-php-ext-install igbinary

RUN NPROC=$(getconf _NPROCESSORS_ONLN) \
    && mkdir -p /usr/src/php/ext \
    && cd /usr/src/php/ext \
    && pecl bundle redis \
    && docker-php-ext-configure redis --enable-redis-igbinary --enable-redis-lzf \
    && docker-php-ext-install -j${NPROC} redis \
    && rm -rf /tmp/pear

RUN touch /home/www-data/.bashrc | echo "PS1='\w\$ '" >> /home/www-data/.bashrc

ENV DOCKERIZE_VERSION v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chmod 0777 /var/spool/cron/crontabs/

COPY .docker/supervisor/supervisor.conf /etc/supervisor/conf.d/
# RUN usermod -u 1000 www-data

WORKDIR /var/www

RUN rm -rf /var/www/html && ln -s public html

# USER www-data

#cron shoul run out of container otherwise all container would run it, but fot this concept project it is ok to be here.
RUN echo "* * * * * /usr/local/bin/php /var/www/artisan schedule:run > /dev/null 2>&1" >> /var/spool/cron/crontabs/root

EXPOSE 9000 6001
