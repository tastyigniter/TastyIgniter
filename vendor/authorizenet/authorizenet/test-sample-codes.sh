#!/bin/bash

for file in $(find sample-code-php/ -name '*.php')
do
	php $file
done