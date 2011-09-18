Link a user model
=================

There is no user entity in the forum bundle because it's not its business.
The bundle assumes that you already have a _user_ model somewhere in your
application or you can install a bundle like the [FOSUserBundle][fos-user].

Howerver, it's a common need for a forum to have its _topics_ and _posts_
linked to a user. Here is how to setup such a functionality.

Create a blamer
---------------

The blamer is responsible of linking the forum models to your user model. It is
invoked on Topic / Post creation.

The bundle contains an abstract blamer class that is aware of the Symfony
security. You can create your custom blamer extending it:

    <?php

    namespace Acme\ForumBundle\Blamer;

    use Herzult\Bundle\ForumBundle\Blamer\AbstractSecurityBlamer;

    class Blamer extends AbstractSecurityBlamer
    {
        public function blame($object)
        {
            $object->setAuthor($this->security->getToken()->getUser());
        }
    }

Once you created your blamer(s), you must update the bundle's configuration:

    # app/config/config.yml
    herzult_forum:
        class:
            blamer:
                topic:  Acme\ForumBundle\Blamer\TopicBlamer
                post:   Acme\ForumBundle\Blamer\PostBlamer

[fos-user]: https://github.com/FriendsOfSymfony/FOSUserBundle.git
