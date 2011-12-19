FreERMS
=======

FreERMS is an Electronic Resource Management System written as a bundle for
the symfony web framework. It is focused on providing access at the database
level in a multi-library or consortial environment. It comes packaged with
several AccessHandler classes, which represent different ways that users
may connect to resources from on- or off-campus; for example, Referer Url,
EZproxy, or direct HTTP access. Custom authentication simply requires
writing a new AccessHandler class.

Installation
------------

* Add to your `deps` file:

        [FreermsBundle]
            git=http://github.com/yitznewton/freerms.git
            target=/bundles/Yitznewton/FreermsBundle

* Do `bin/vendors install`

* Add a line to your `autoload.php`:

        $loader->registerNamespaces(array(
            // ...
            'Yitznewton' => __DIR__.'/../vendor/bundles',
        ));

* Add a line to your `AppKernel.php`:

        $bundles = array(
            // ...
            new Yitznewton\FreermsBundle\FreermsBundle(),
        );

