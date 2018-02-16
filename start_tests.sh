#!/bin/sh
composer install
composer dump-autoload --optimize

vendor/codeception/codeception/codecept clean
vendor/codeception/codeception/codecept build
vendor/codeception/codeception/codecept run --steps --html --debug