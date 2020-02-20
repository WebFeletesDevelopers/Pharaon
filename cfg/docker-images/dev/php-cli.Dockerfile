FROM php:7.4-cli

RUN pecl install xdebug-2.9.1 \
  && docker-php-ext-enable xdebug

WORKDIR /
RUN curl https://getcomposer.org/installer -o composer-install.php \
  && php composer-install.php --install-dir=/usr/local/bin --filename="composer" \
  && rm composer-install.php

RUN apt-get update -y \
 && apt-get install -y \
    graphviz \
    libicu-dev \
    git \
    unzip \
 && rm -rf /var/lib/apt/lists/*

RUN composer global require hirak/prestissimo

RUN curl -OL https://github.com/phpDocumentor/phpDocumentor/releases/download/v3.0.0-rc/phpDocumentor.phar \
 && chmod +x phpDocumentor.phar \
 && mv phpDocumentor.phar /usr/local/bin/phpdoc

WORKDIR /app
