<?php

namespace Bundle\ForumBundle\Util;

class Search
{
    /**
     * @Validation({
     *   @NotBlank(),
     *   @MinLength(limit=3, message="Just a little too short.")
     * })
     */
    public $query;
}
