<?php

namespace Bundle\ForumBundle\Blamer;

use Symfony\Component\Security\SecurityContext;

abstract class AbstractSecurityBlamer
{
    protected $security;

    public function __construct(SecurityContext $security = null)
    {
        $this->security;
    }
}
