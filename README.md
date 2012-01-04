FreERMS
=======

FreERMS is an electronic resource management system for libraries. It is
written in PHP using the symfony framework (1.4). It requires PHP 5.3, and
has been tested on Ubuntu Linux systems.

symfony is very well documented; the project homepage is
http://www.symfony-project.org/

Installation
------------

* Clone the git repo

* Symlink or install symfony-1.4 as `vendor/symfony-1.4`

* Add a symlink in `/web` pointing to the symfony assets directory, or copy
  it, e.g.:

        /home/fred/freerms/web$ ln -s ../vendor/symfony-1.4/data/web/sf

* Specify your database connection in
  `config/databases.yml`

* Add missing directories:

        /home/fred/freerms$ mkdir log

* Install sfGuardPlugin and publish plugin assets:

        /home/fred/freerms$ ./symfony plugin:install sfGuardPlugin
        /home/fred/freerms$ ./symfony plugin:publish-assets

* Run a Doctrine build. Use a custom form generator to avoid a symfony
  bug/feature:

        /home/fred/freerms$ ./symfony doctrine:build --all
        /home/fred/freerms$ ./symfony doctrine:build-forms \
          --generator-class=freermsDoctrineFormGenerator

* Clear symfony's internal cache (incidentally, always a good idea if
  something looks inexplicably broken during installation or update):

        /home/fred/freerms$ ./symfony cc

* Create a superuser:

        /home/fred/freerms$ ./symfony guard:create-user jimbo mypassword
        /home/fred/freerms$ ./symfony guard:promote jimbo

At this point, you will be able to set your web server's document root to
symfony's `web` directory, and connect to the `/admin` app with the user
you have just created. In order to use the resolver (i.e. public-facing)
app, you will need to associate your user with one or more libraries, by
adding rows to the sf_guard_user_group table. You can modify user data
via scripts or directly in the database, or create an admin module within
symfony.

Access handlers
---------------

One of the main functions of FreERMS is acting as a link resolver to your
institution's databases, which includes invoking a proxy server or Referer-
based authentication as needed. Resources can be assigned the proper
"access handler" to accomplish this: one for on-campus users, and another
for off-campus users. A number of standard access handlers are included with
FreERMS, including one for ticket-based EZproxy authentication, and ebrary
single sign-on. Inevitably, however, some resources will require
local customization.

To add a custom access handler, create a new PHP class at
`/lib/access/custom/AccessInfoXYZAccessHandler.class.php`
(the correct class name is indicated in the database form in the Access tab)
which extends `BaseAccessHandler`. FreERMS will call the `execute()` method
of the `AccessHandler` instance when a user requests the resource. A sample
AccessHandler has been provided with FreERMS.

Caching frontend pages
----------------------

The frontend database listing pages are relatively expensive to the
database. To enable the frontend cache:

* Uncomment the `cache: true` setting in
  `apps/resolver/modules/database/config/settings.yml`

Extending FreERMS
-----------------

It is not difficult to modify FreERMS, for example, to use an alternate user
backend. (Explain how.)
