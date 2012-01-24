FreERMS Test Harness
====================

To use the automated tests, you must install and enable
sfPHPUnit2Plugin and vfsStream:

    $ ./symfony plugin:install --stability=beta sfPHPUnit2Plugin
    $ pear channel-discover pear.php-tools.net
    $ pear install pat/vfsStream-beta

The test harness is run by doing

    $ ./test/run_tests.sh

You can also call tests individually, e.g.

    $ phpunit test/phpunit/unit/widget/sfWidgetFormDoctrineEnumTest.php

The test harness omits the Selenium tests by default. To run them, you must 
specify your browser(s) and other settings in
`test/phpunit/selenium/FreermsSeleniumTestCase.php`. Then do

    $ ./test/run_tests.sh --with-selenium

