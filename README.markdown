The ForumBundle offers a simple Symfony2 forum.

It's currently under *intensive* development.

## Installation

### Add ForumBundle to your src/Bundle dir

    git submodule add git://github.com/Herzult/ForumBundle.git src/Bundle/ForumBundle

### Add ForumBundle to your application kernel

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Bundle\ForumBundle\ForumBundle(),
            // ...
        );
    }

### Choose ORM or ODM database driver

    # app/config.yml
    forum.config:
        db_driver: orm # can be orm or odm

or if you prefer xml

    # app/config.xml
    <forum:config db_driver="orm"/> <!-- can be orm or odm -->

### Add authentication routes

If you want ready to use routing, include the builtin routes:

    # app/config/routing.yml
    forum:
        resource: ForumBundle/Resources/config/routing.xml

in xml

    # app/config/routing.xml
    <import resource="ForumBundle/Resources/config/routing.xml"/>
