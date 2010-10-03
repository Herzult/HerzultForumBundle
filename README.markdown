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

### Create your own Category, Topic and Post classes

You must create entity/document classes that extend the default ones.
Then you will be able to add logic and mapping in them.

#### MongoDB classes:

Category:
    // src/Application/ForumBundle/Document/Category.php

    namespace Application\ForumBundle\Document;
    use Bundle\ForumBundle\Document\Category as BaseCategory;

    class Category extends BaseCategory {}

Topic:
    // src/Application/ForumBundle/Document/Topic.php

    namespace Application\ForumBundle\Document;
    use Bundle\ForumBundle\Document\Topic as BaseTopic;

    class Topic extends BaseTopic {}

Post:
    // src/Application/ForumBundle/Document/Post.php

    namespace Application\ForumBundle\Document;
    use Bundle\ForumBundle\Document\Post as BasePost;

    class Post extends BasePost {}

### Choose ORM or ODM database driver and declare object classes

    # app/config.yml
    forum.config:
        db_driver: orm # can be orm or odm
        category_class: Bundle\Application\ForumBundle\Entity\Category
        topic_class: Bundle\Application\ForumBundle\Entity\Topic
        post_class: Bundle\Application\ForumBundle\Entity\Post
        user_class: Bundle\Application\DoctrineUserBundle\Entity\User

### Add authentication routes

If you want ready to use routing, include the builtin routes:

    # app/config/routing.yml
    forum:
        resource: ForumBundle/Resources/config/routing/forum.xml
        prefix:     /forum
    forum_category:
        resource: ForumBundle/Resources/config/routing/category.xml
        prefix:     /forum
    forum_topic:
        resource: ForumBundle/Resources/config/routing/topic.xml
        prefix:     /forum

in xml

    # app/config/routing.xml
    <import resource="ForumBundle/Resources/config/routing.xml"/>
