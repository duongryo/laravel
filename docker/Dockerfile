FROM wyveo/nginx-php-fpm:php74

MAINTAINER andy@resonancetech.co

#Install extensions
RUN apt-get update -y \
    && apt-get install -y php7.4-soap \
    && apt-get install -y npm \
    && npm install npm@latest -g \
    && apt-get install -y openssl \
    && apt-get install -y curl


#Install SSL
ARG DOMAIN

ENV DOMAIN $DOMAIN

COPY ./docker/ssl/generate.sh /etc/nginx/ssl/generate-ssl.sh

RUN chmod +x /etc/nginx/ssl/generate-ssl.sh

RUN cd /etc/nginx/ssl && ./generate-ssl.sh

#Update NodeJS
COPY ./docker/script/npm-update.sh /npm-update.sh

RUN chmod +x /npm-update.sh

RUN /npm-update.sh