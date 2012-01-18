#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

find $DIR/test/phpunit -name *Test.php -print -exec phpunit --colors {} \;

