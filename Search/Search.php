<?php

namespace Bundle\ForumBundle\Search;

use Symfony\Component\Validator\Constraints as Assert;

class Search
{
    /**
     * @Assert\Validation({
     *   @Assert\NotBlank(),
     *   @Assert\MinLength(limit=3, message="Just a little too short.")
     * })
     */
    public $query;
}