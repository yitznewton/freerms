FreERMS
=======

FreERMS is an electronic resource management system for libraries. It is
written in PHP using the symfony framework (1.4). It requires PHP 5.3, and
has been tested on Ubuntu Linux systems.

symfony is very well documented; the project homepage is
http://www.symfony-project.org/

Installation
------------

* Clone the FreERMS git repo

        /home/fred$ git clone https://github.com/yitznewton/freerms.git

* FreERMS requires a slightly modified version of symfony. It is registered as
  a submodule of the FreERMS git repo; if you are installing manually,
  the symfony 1.4 filesystem should be symlinked or added as
  `vendor/symfony-1.4`

  The modified repo is https://github.com/yitznewton/symfony1

* Add a symlink in `/web` pointing to the symfony assets directory, or copy
  it, e.g.:

        /home/fred/freerms/web$ ln -s ../vendor/symfony-1.4/data/web/sf

* Specify your database connection in
  `config/databases.yml`

* Add missing directories:

        /home/fred/freerms$ mkdir cache log

* Install sfGuardPlugin and publish plugin assets:

        /home/fred/freerms$ ./symfony plugin:install sfDoctrineGuardPlugin
        /home/fred/freerms$ ./symfony plugin:publish-assets

* Run a Doctrine build. 

        /home/fred/freerms$ ./symfony doctrine:build --all

* Clear symfony's internal cache (incidentally, always a good idea if
  something looks inexplicably broken during installation or update):

        /home/fred/freerms$ ./symfony cc

* Create a superuser:

        /home/fred/freerms$ ./symfony guard:create-user jimbo mypassword
        /home/fred/freerms$ ./symfony guard:promote jimbo

At this point, you will be able to set your web server's document root to
symfony's `web` directory, and connect to the `/backend.php` app with the user
you have just created. In order to use the resolver (i.e. public-facing)
app, you will need to associate your user with one or more libraries, by
adding rows to the sf_guard_user_group table. You can modify user data
via scripts or directly in the database, or create an admin module within
symfony.

sfDoctrineGuardPlugin documentation is available at
http://www.symfony-project.org/plugins/sfDoctrineGuardPlugin

Basic setup
-----------

After accessing the `/backend.php` admin area, you will need to define your
libraries and IP ranges. You can then add databases. You must specify an on-
and off-campus access action for each (see below).

After selecting subject for each database, you can choose specific databases
to feature on the homepage via `/backend.php/databases/featured`, or on subject
pages via each subject's admin page.

Access actions
---------------

One of the main functions of FreERMS is acting as a link resolver to your
institution's databases, which includes invoking a proxy server or Referer-
based authentication as needed. Resources can be assigned the proper
"access action" to accomplish this: one for on-campus users, and another
for off-campus users. A number of standard access actions are included with
FreERMS, including one for ticket-based EZproxy authentication, and ebrary
single sign-on. Inevitably, however, some resources will require
local customization.

To add a custom access action, create a new PHP class at
`/apps/frontend/modules/access/actions/XYZAccessAction.class.php`
which extends `baseAccessAction`. FreERMS will call the `execute()` method
of the `AccessHandler` instance when a user requests the resource.

Alternate authentication
-----------------

To use an authentication system other than sfDoctrineGuardPlugin, you will
need a customized class which implements `freermsSecurityUser`. In doing
so, Touro College (the sponsor of FreERMS's development) extended the
sfDoctrineGuardPlugin user class, overriding certain key methods.

You may also want a customized DataService class to include local user data
in the usage logs.

Because of security concerns, Touro is not including their customizations in
the main repository. Please contact yitznewton@hotmail.com if you wish to
discuss the details.

Usage logs
----------

Usage of databases and access of URLs are logged in the `database_usage` and
`url_usage` tables of FreERMS's database. At present, these need to be queried
by hand. A reporting module is planned.

