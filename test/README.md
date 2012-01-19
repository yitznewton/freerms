FreERMS Test Harness
====================

To use the automated tests, you must install and enable
sfPHPUnit2Plugin and vfsStream:

    $ ./symfony plugin:install --stability=beta sfPHPUnit2Plugin
    $ pear channel-discover pear.php-tools.net
    $ pear install pat/vfsStream-beta

To run tests:

    $ ./test/run_tests.sh

