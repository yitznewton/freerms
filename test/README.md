FreERMS Test Harness
====================

To use the automated tests, you must install and enable
sfPHPUnit2Plugin and vfsStream:

    $ ./symfony plugin:install --stability=beta sfPHPUnit2Plugin
    $ pear channel-discover pear.php-tools.net
    $ pear install pat/vfsStream-beta

The test harness assumes that you have Selenium set up. You must specify
your browser(s) and other settings in
`test/phpunit/selenium/FreermsSeleniumTestCase.php`.

If you do not have Selenium, simply set the `$browsers` static property
in `FreermsSeleniumTestCase` to `array()`.

To run tests:

    $ ./test/run_tests.sh

