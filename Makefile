all: install build static swagger run

install:
	bash install.sh

build:
	docker-compose -f ci/docker/local.yaml build base
	docker-compose -f ci/docker/local.yaml build --no-cache --build-arg hostUID=`id -u` --build-arg hostGID=`id -g` web

image:
	docker build -f ci/docker/Dockerfile.base --tag training_start:base .
	docker build -f ci/docker/Dockerfile --tag registry.saritasa.com/training_start/backend:develop .

start: run

run:
	docker-compose -f ci/docker/local.yaml -p training_start up -d web

stop:
	docker-compose -f ci/docker/local.yaml -p training_start kill

destroy:
	docker-compose -f ci/docker/local.yaml -p training_start down

logs:
	docker-compose -f ci/docker/local.yaml -p training_start logs -f web

shell:
	docker-compose -f ci/docker/local.yaml -p training_start exec --user nginx web bash

root:
	docker-compose -f ci/docker/local.yaml -p training_start exec web bash

cs:
	php vendor/bin/phpcs --parallel=4

csfix:
	php vendor/bin/phpcbf --parallel=4

test:
	php vendor/bin/phpunit

test2:
	docker-compose -f ci/docker/testing_local.yml -p training_start_tests run --rm tests || \
	docker-compose -f ci/docker/testing_local.yml -p training_start_tests down

static:
	yarn run development

watch:
	yarn run watch

lint:
	yarn run lint

lintfix:
	yarn run lint:fix

swagger:
	npx swagger-cli validate docs/API/index.yaml
	npx swagger-cli bundle --type yaml --outfile public/swagger-ui/api.yaml docs/API/index.yaml

ip:
	docker inspect training_start-web | grep \"IPAddress\"
