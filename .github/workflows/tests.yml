name: Tests

on:
  push:
    branches:
      - master
      - develop
      - 3.x
  pull_request:

jobs:
  PHPUnitTests:
#    runs-on: ${{ matrix.os }}
    runs-on: ubuntu-latest
    strategy:
      max-parallel: 6
      matrix:
#        os: [ubuntu-latest, windows-latest]
        php: ['7.4', '8.0', '8.1']
        db: ['mysql:5.7', 'mysql:8.0', 'mariadb:10.2', 'mariadb:10.6']
        include:
          - db: 'mysql:5.7'
            dbName: 'MySQL 5.7'
          - db: 'mysql:8.0'
            dbName: 'MySQL'
          - db: 'mariadb:10.2'
            dbName: 'MariaDB 10.2'
          - db: 'mariadb:10.6'
            dbName: 'MariaDB'
      fail-fast: false

    services:
      mysql:
        image: ${{ matrix.db }}
        ports:
          - 3306

    name: 'PHPUnit Tests ${{ matrix.php }} / ${{ matrix.dbName }}'

    steps:
      - name: Checkout changes
        uses: actions/checkout@v1

      - name: Create MySQL Database
        run: |
          sudo systemctl start mysql
          mysql -u${{ env.DB_USERNAME }} -p${{ env.DB_PASSWORD }} -e 'CREATE DATABASE ${{ env.DB_DATABASE }};' --port ${{ env.DB_PORT }}

      - name: Install PHP
        uses: shivammathur/setup-php@master
        with:
          php-version: ${{ matrix.php }}
          extensions: mbstring, intl, gd, xml, sqlite

      - name: Install composer dependencies
        run: composer install --no-interaction --prefer-dist --no-progress --no-scripts

      - name: Reset TastyIgniter library
        run: |
          git reset --hard HEAD
          rm -rf ./vendor/tastyigniter/flame
          wget https://github.com/tastyigniter/flame/archive/master.zip -O ./vendor/tastyigniter/master.zip
          unzip ./vendor/tastyigniter/master.zip -d ./vendor/tastyigniter
          mv ./vendor/tastyigniter/flame-master ./vendor/tastyigniter/flame
          composer dump-autoload

      - name: Run composer post-update scripts
        run: |
          php artisan key:generate --force
          php artisan igniter:install --no-interaction
          php artisan igniter:util set version
          php artisan package:discover

      - name: Run PHPUnit Test Suite
        run: ./vendor/bin/phpunit

    env:
      DB_PORT: 3306
      DB_DATABASE: test
      DB_USERNAME: root
      DB_PASSWORD: root
      DB_PREFIX: 'ti_'
      IGNITER_LOCATION_MODE: multiple
