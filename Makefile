LOGIN := yuliaqueen
REGISTRY := ghcr.io/$(LOGIN)
BRANCH_NAME := $(shell git rev-parse --abbrev-ref HEAD)
BUILD_NUMBER := $(shell cat .build_number 2>/dev/null || echo 0)
NEW_BUILD_NUMBER := $(shell echo $$(($(BUILD_NUMBER) + 1)))
IMAGE_TAG := $(BRANCH_NAME)-$(NEW_BUILD_NUMBER)

init: docker-down-clear docker-pull docker-build docker-up
up: docker-up
down: docker-down
restart: down up

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build --pull

build: increment-build-number build-gateway build-frontend build-api

increment-build-number:
	@echo $(NEW_BUILD_NUMBER) > .build_number

build-gateway:
	docker build --pull --file=gateway/docker/production/nginx/Dockerfile --tag=${REGISTRY}/auction-gateway:${IMAGE_TAG} gateway/docker/production/nginx

build-frontend:
	docker build --pull --file=frontend/docker/production/nginx/Dockerfile --tag=${REGISTRY}/auction-frontend:${IMAGE_TAG} frontend

build-api:
	docker build --pull --file=api/docker/production/php-fpm/Dockerfile --tag=${REGISTRY}/auction-api-php-fpm:${IMAGE_TAG} api
	docker build --pull --file=api/docker/production/nginx/Dockerfile --tag=${REGISTRY}/auction-api:${IMAGE_TAG} api

push:
	docker push ${REGISTRY}/auction-gateway:${IMAGE_TAG}
	docker push ${REGISTRY}/auction-frontend:${IMAGE_TAG}
	docker push ${REGISTRY}/auction-api-php-fpm:${IMAGE_TAG}
	docker push ${REGISTRY}/auction-api:${IMAGE_TAG}

build-and-push: build push

try-build:
	make build

docker-login:
	@echo ${GITHUB_PAT} | docker login ${REGISTRY} -u ${LOGIN} --password-stdin