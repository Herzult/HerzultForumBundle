Doctrine ORM
============

If you choosed the `orm` database driver, you can continue installing the
bundle with the following instructions.

Create the entity classes
-------------------------

The bundle does not contains any concrete Doctrine entity but only a _mapped
superclass_ for each model. So you have to create your own entity classes
extending them.

As it is not possible to define _relations_ or _repository classes_ on the
_mapped superclasses_, you must map it on your entities.

### The Category entity

    <?php

    namespace Acme\ForumBundle\Entity;

    use Herzult\Bundle\ForumBundle\Entity\Category as BaseCategory
    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity(repositoryClass="Herzult\Bundle\ForumBundle\Entity\CategoryRepository")
     */
    class Category extends BaseCategory
    {
    }

### The Topic entity


    <?php

    namespace Acme\ForumBundle\Entity;

    use Herzult\Bundle\ForumBundle\Entity\Topic as BaseTopic;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity(repositoryClass="Herzult\Bundle\ForumBundle\Entity\TopicRepository")
     */
    class Topic extends BaseTopic
    {
        /**
         * @ORM\ManyToOne(targetEntity="Category")
         */
        protected $category;

        /**
         * {@inheritDoc}
         */
        public function getAuthorName()
        {
            return 'anonymous';
        }
    }

As you can see, there is a `->getAuthorName()` method returning an hard-coded
string. This is because we did not configure any _blamer_ yet. We will speak
about it later

### The Post entity

    <?php

    namespace Acme\ForumBundle\Entity;

    use Herzult\Bundle\ForumBundle\Entity\Post as BasePost;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity(repositoryClass="Herzult\Bundle\ForumBundle\Entity\PostRepository")
     */
    class Post extends BasePost
    {
        /**
         * @ORM\ManyToOne(targetEntity="Topic")
         */
        protected $topic;

        public function getAuthorName()
        {
            return 'anonymous';
        }
    }

The `->getAuthorName()` follows the same principle as the one we saw in the
Topic entity.

### Link a user

You can optionaly link your _topics_ and _posts_ to a user entity. If so, you
must update your Topic model:

    <?php

    class Topic extends BaseTopic
    {
        // ...

        /**
         * @ORM\ReferenceOne(targetEntity="User")
         */
        private $author;

        public function setAuthor(User $user)
        {
            $this->author = $user;
        }

        public function getAuthor()
        {
            return $this->author;
        }
    }

Same for your Post model:

    <?php

    class Post extends BasePost
    {
        // ...

        /**
         * @ORM\ReferenceOne(targetEntity="User")
         */
        private $author;

        public function setAuthor(User $user)
        {
            $this->author = $user;
        }

        public function getAuthor()
        {
            return $this->author;
        }
    }

Then you must follow the [dedicated documentation][link-user-model].

[link-user-model]: link-user-model.markdown
