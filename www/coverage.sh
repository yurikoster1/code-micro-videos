#!/usr/bin/env sh

vendor/bin/phpunit --coverage-xml=build/coverage/coverage-xml --log-junit=build/coverage/junit.xml
