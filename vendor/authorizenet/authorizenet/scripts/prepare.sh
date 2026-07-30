#!/bin/bash

echo "Preparing for SDK Generation : `date`"

cp composer.json composer.json.backup
cp scripts/composer.json.masterUpdate composer.json

composer update
