FROM php:8.2.3-fpm

RUN apt-get update && \
    apt-get install -y --no-install-recommends libssl-dev zlib1g-dev curl git unzip netcat libxml2-dev libpq-dev libzip-dev && \
    docker-php-ext-install -j$(nproc) zip intl pdo_mysql && \
    docker-php-ext-enable pdo_mysql sodium && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Trick to fix issue with permissions:
ARG UID
ARG GID
ENV UID=${UID}
ENV GID=${GID}
RUN echo $UID
RUN addgroup --gid ${GID} --system symfony
RUN adduser --ingroup symfony --system --disabled-password --shell /bin/bash -u ${UID} symfony
USER symfony

COPY --from=composer:2.5.4 /usr/bin/composer /usr/local/bin/composer
WORKDIR /var/www
EXPOSE 9000
