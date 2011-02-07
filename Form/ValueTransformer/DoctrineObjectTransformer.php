<?php

namespace Bundle\ForumBundle\Form\ValueTransformer;
use Symfony\Component\Form\ValueTransformer\ValueTransformerInterface;
use Symfony\Component\Form\Configurable;

/**
 * Transforms between a doctrine object and an id
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class DoctrineObjectTransformer extends Configurable implements ValueTransformerInterface
{
    /**
     * Object repository
     *
     * @var mixed
     */
    protected $repository = null;

    public function __construct($repository)
    {
        if(!method_exists($repository, 'find')) {
            throw new \InvalidArgumentException('The repository must implement a find method');
        }
        $this->repository = $repository;
    }

    /**
     * Transforms an object into an id
     *
     * @param  mixed $value     Object
     * @return string           String id
     */
    public function transform($value)
    {
        if(null === $value) {
            return null;
        }

        if (!is_object($value)) {
            throw new \InvalidArgumentException(sprintf('Expected argument of type object but got %s.', gettype($value)));
        }

        if(!method_exists($value, 'getId')) {
            throw new \InvalidArgumentException('The object must implement a getId method');
        }

        return $value->getId();
    }

    public function reverseTransform($value)
    {
        return $this->repository->find($value);
    }
}
