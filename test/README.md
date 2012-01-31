FreERMS Test Harness
====================

To use the automated tests, you must install and enable
sfPHPUnit2Plugin and vfsStream:

    $ ./symfony plugin:install --stability=beta sfPHPUnit2Plugin
    $ pear channel-discover pear.php-tools.net
    $ pear install pat/vfsStream-beta

The test harness is run via the following script, with any of the three
arguments shown:

    $ ./test/run_tests.sh --unit --functional --selenium

You can also call tests individually, e.g.

    $ phpunit --colors test/phpunit/unit/widget/sfWidgetFormDoctrineEnumTest.php

To run the Selenium tests, you must 
specify your browser(s) and other settings in
`test/phpunit/selenium/FreermsSeleniumTestCase.php`. Then you can do

    $ ./test/run_tests.sh --selenium

