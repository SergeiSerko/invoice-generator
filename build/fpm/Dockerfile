FROM php:7.4-fpm-bullseye

ARG workdir=/www/app
RUN mkdir -p $workdir

# timezone
ENV TZ=Europe/Helsinki
RUN cp /usr/share/zoneinfo/$TZ /etc/localtime \
    && echo $TZ > /etc/timezone

WORKDIR $workdir

RUN apt-get update -q -y \
    && apt-get install -q -y \
        gnupg2 \
        ca-certificates \
        apt-transport-https \
        curl \
        git \
        unzip \
        libonig-dev \
        libxml2-dev \
        wget \
    && wget -q https://packages.sury.org/php/apt.gpg -O- | apt-key add - \
    && echo "deb https://packages.sury.org/php/ bullseye main" | tee /etc/apt/sources.list.d/php.list \
    && apt-get update -q -y \
    && docker-php-ext-install \
        mbstring \
        bcmath \
        json \
        pdo_mysql \
        xml \
        intl

# entrypoint
COPY ./build/fpm/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
#EXPOSE 9000

CMD ["/entrypoint.sh"]

