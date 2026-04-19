FROM php:8.3-fpm AS php

#---------------------------------------------------- Set username and UID/GID ----------------------------------------#
ARG uid=1001
ENV user=user uid=$uid
#----------------------------------------------------------------------------------------------------------------------#

#---------------------------------------- Update and install system dependencies --------------------------------------#
RUN apt-get update && apt-get install -y \
    cron \
    curl \
    git \
    htop \
    jpegoptim \
    libpq-dev \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxml2-dev \
    libxslt-dev \
    libwebp-dev \
    libzip-dev \
    locales \
    locales-all \
    pkg-config \
    sudo \
    supervisor \
    tzdata \
    webp \
    zip \
    && rm -rf /var/lib/apt/lists/*
#----------------------------------------------------------------------------------------------------------------------#

#---------------------------------------------- Install PHP extensions ------------------------------------------------#
RUN docker-php-ext-install \
    bcmath \
    calendar \
    exif \
    intl \
    opcache \
    pcntl \
    xsl \
    zip
#----------------------------------------------------------------------------------------------------------------------#

RUN docker-php-ext-configure gd --with-jpeg --with-webp && \
    docker-php-ext-install gd

#------------------------------------------ Copy php.ini --------------------------------------------------------------#
COPY /php/php.ini /usr/local/etc/php/php.ini
#----------------------------------------------------------------------------------------------------------------------#

#---------------------------------- Create system user ----------------------------------------------------------------#
RUN useradd --groups=www-data,root --uid=$uid --home-dir=/home/$user $user
RUN passwd -d -u $user

RUN mkdir /home/$user && \
    chown -R $user:$user /var/www

RUN adduser $user sudo
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers
#----------------------------------------------------------------------------------------------------------------------#

#--------------------------------------------- Install composer -------------------------------------------------------#
RUN mkdir /home/$user/.composer

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
#----------------------------------------------------------------------------------------------------------------------#

#------------------------------------------------- Set timezone -------------------------------------------------------#
ENV TZ=Europe/Moscow
RUN cp /usr/share/zoneinfo/Europe/Moscow /etc/localtime
#----------------------------------------------------------------------------------------------------------------------#

#--------------------------------------------------- Set locale -------------------------------------------------------#
ENV LANG=ru_RU.UTF-8
ENV LANGUAGE=ru:en_US:en

RUN echo -e "en_US.UTF-8 UTF-8 \\nru_RU.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen
#----------------------------------------------------------------------------------------------------------------------#

#--------------------------------------- Set config supervisor --------------------------------------------------------#
RUN mkdir -p /etc/supervisor.d/
COPY /supervisor/supervisord.conf /etc/supervisord.conf
COPY /supervisor/laravel/example.conf /etc/supervisor/laravel.conf
#----------------------------------------------------------------------------------------------------------------------#

#----------------------------------------- Set config crontab ---------------------------------------------------------#
RUN echo "* * * * * $user php /var/www/artisan schedule:run 2>&1" >> /etc/crontab
#----------------------------------------------------------------------------------------------------------------------#

#--------------------------------------------- Set custom entrypoint --------------------------------------------------#
COPY /php/start.sh /usr/bin/start.sh
RUN chmod +x /usr/bin/start.sh

CMD ["sh", "/usr/bin/start.sh"]
#----------------------------------------------------------------------------------------------------------------------#

#------------------- Set the user as the owner of the home directory and all directories and files in it --------------#
RUN chown -R $user:$user /home/$user

#------------------------------------- Set working directory and active user ------------------------------------------#
WORKDIR /var/www/

FROM php AS production
USER $user

#---------------------------------------- Install xdebug --------------------------------------------------------------#
FROM php AS dev
ARG uid=1002
RUN usermod -u $uid $user && chown -R $user:$user /home/$user
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
USER $user
#----------------------------------------------------------------------------------------------------------------------#
