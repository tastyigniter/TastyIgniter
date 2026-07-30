#!/bin/bash

cd ${TRAVIS_BUILD_DIR}

if [[ $TRAVIS_PHP_VERSION = '7.1' ]]; then
    phpunit
fi

if [[ $TRAVIS_PHP_VERSION = '7.2' ]]; then
    phpunit
fi

if [[ $TRAVIS_PHP_VERSION = '7.3' ]]; then
    phpunit
fi