#!/usr/bin/make
SHELL = /bin/sh

UID := $(shell id -u)
GID := $(shell id -g)

export UID
export GID

define composer-install
	docker-compose exec php composer install
endef

up:
	docker-compose up -d
	$(call composer-install)

up_recreate:
	docker-compose up -d --force-recreate
	$(call composer-install)

build_php:
	docker-compose build php

build_nginx:
	docker-compose build nginx

bash:
	docker-compose exec php /bin/bash

fixtures:
	docker-compose exec php bin/console doctrine:fixtures:load -n
