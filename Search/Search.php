<?php

namespace Herzult\Bundle\ForumBundle\Search;

use Symfony\Component\Validator\Constraints as Assert;

class Search
{
    /**
     * @Assert\NotBlank(),
     * @Assert\MinLength(limit=3, message="Just a little too short.")
     */
    protected $query;

	public function getQuery() {
		return $this->query;
	}

	public function setQuery($query) {
		$this->query = $query;
		return $this;
	}
}
