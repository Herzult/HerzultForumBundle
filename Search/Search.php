<?php

namespace Bundle\ForumBundle\Search;

class Search
{
    /**
     * @assert:Validation({
     *   @assert:NotBlank(),
     *   @assert:MinLength(limit=3, message="Just a little too short.")
     * })
     */
    public $query;
}
