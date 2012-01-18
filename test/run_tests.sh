#!/bin/bash

TIME_BEGIN=$(date '+%s')

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

find $DIR/phpunit -name *Test.php -print -exec phpunit --colors {} \;

TIME_END=$(date '+%s')

printf '\nTOTAL TIME: %s seconds\n\n' $(($TIME_END-$TIME_BEGIN))

