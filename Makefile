dcompose=docker-compose
devfile=docker-compose-dev.yml
php_container=php
database_container=db

.PHONY: docs

docker-images-dev:
	$(dcompose) -f $(devfile) pull
	$(dcompose) -f $(devfile) build

dependencies-dev:
	$(dcompose) -f $(devfile) run $(php_container) composer install ${args}

update-dependencies-dev:
	$(dcompose) -f $(devfile) run $(php_container) composer update ${args}


scripts:
	sh cfg/scripts/set_up_git_hooks.sh

build-dev: docker-images-dev dependencies-dev scripts

start-dev:
	$(dcompose) -f $(devfile) up -d db

phpunit:
	$(dcompose) -f $(devfile) run $(php_container) php vendor/bin/phpunit -c test/phpunit.xml

phpunit-coverage:
	$(dcompose) -f $(devfile) run $(php_container) php vendor/bin/phpunit -c test/phpunit.xml --coverage-html test/coverage

command:
	$(dcompose) -f $(devfile) run $(php_container) $(args)

phpstan:
	$(dcompose) -f $(devfile) run $(php_container) vendor/bin/phpstan analyse src test --level 8

phpcs:
	$(dcompose) -f $(devfile) run $(php_container) vendor/bin/phpcs --standard=/app/custom_ruleset.xml --ignore="test/coverage" -p --colors src test

infection:
	$(dcompose) -f $(devfile) run $(php_container) vendor/bin/infection --threads=4

docs:
	$(dcompose) -f $(devfile) run $(php_container) phpdoc -d ./src -t ./docs --template="clean"
