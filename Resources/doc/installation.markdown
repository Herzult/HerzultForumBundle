Installation
============

This document explains the generic installation steps, once you have done with
it, you must also follow the instructions specific to the database driver you
are using.

Grab the sources
----------------

Update your `deps` file adding the following lines:

    [Pagerfanta]
        git=https://github.com/whiteoctober/Pagerfanta.git
        target=/pagerfanta

    [WhiteOctoberPagerfantaBundle]
        git=https://github.com/whiteoctober/WhiteOctoberPagerfantaBundle.git
        target=/bundles/WhiteOctober/PagerfantaBundle

    [HerzultForumBundle]
        git=http://github.com/Herzult/HerzultForumBundle.git
        target=/bundles/Herzult/Bundle/ForumBundle

    [DoctrineExtensions]
        git=https://github.com/l3pp4rd/DoctrineExtensions.git
        target=/bundles/doctrine-extensions

And install the new dependencies:

    $ ./bin/vendor install

Add them to the autoloader
--------------------------

Register the namespaces that are not already registered in your autoloader:

    // app/autoloader.php
    $autoloader->registerNamespaces(array(
        // ...
        'Pagerfanta'    => __DIR__.'/../vendor/pagerfanta/src',
        'WhiteOctober'  => __DIR__.'/../vendor/bundles',
        'Herzult'       => __DIR__.'/../vendor/bundles',
        'Gedmo'         => __DIR__.'/../vendor/doctrine-extensions/lib',
    ));

Register the bundles
--------------------

Register both `WhiteOctoberPagerfantaBundle` and `HerzultForumBundle` in your
application kernel:

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new Herzult\Bundle\ForumBundle\HerzultForumBundle(),
        );
    }

Configure the bundle
--------------------

The bundle requires you to write a minimum of configuration.

    # app/config/config.yml
    herzult_forum:
        db_driver:          orm     # can be either "orm" or "odm"
        class:
            model:
                category:   Acme\Model\Category
                topic:      Acme\Model\Topic
                post:       Acme\Model\Post

As you can see, you must choose a database driver and configure your model
classes.

You can now read the documentation specific to the choosed database driver:

 - `orm` [Doctrine ORM][doctrine-orm]
 - `odm` [Doctrine MongoDB ODM][doctrine-mongodb-odm]

 [doctrine-orm]: doctrine-orm.markdown
 [doctrine-mongodb-odm]: doctrine-mongodb-odm.markdown
