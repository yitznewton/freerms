#!/bin/bash

TIME_BEGIN=$(date '+%s')

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

find $DIR/phpunit/unit -name *Test.php -print -exec phpunit --colors {} \;
find $DIR/phpunit/functional -name *Test.php -print -exec phpunit --colors {} \;

for V in $@ ; do
  if [ V="--with-selenium" ] ; then
    find $DIR/phpunit/selenium -name *Test.php -print -exec phpunit --colors {} \;
    break
  fi
done

TIME_END=$(date '+%s')

printf '\nTOTAL TIME: %s seconds\n\n' $(($TIME_END-$TIME_BEGIN))

