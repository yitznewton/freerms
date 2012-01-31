#!/bin/bash

TIME_BEGIN=$(date '+%s')

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
declare -i STATUS=0

for V in $@ ; do
  case $V in
    "--selenium" )
      find $DIR/phpunit/selenium -name *Test.php -print -exec phpunit --colors {} \;
      STATUS+=$?
      ;;

    "--unit" )
      find $DIR/phpunit/unit -name *Test.php -print -exec phpunit --colors {} \;
      STATUS+=$?
      ;;

    "--functional" )
      find $DIR/phpunit/functional -name *Test.php -print -exec phpunit --colors {} \;
      STATUS+=$?
      ;;
  esac
done

TIME_END=$(date '+%s')

printf '\nTOTAL TIME: %s seconds\n' $(($TIME_END-$TIME_BEGIN))

if [ $STATUS -ne 0 ] ; then
  echo -e '\nSome tests failed.\n\n'
fi

echo -e '\n'

exit $STATUS

