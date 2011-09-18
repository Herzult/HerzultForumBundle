<?php

namespace Herzult\Bundle\ForumBundle\Blamer;

use Symfony\Component\Security\Core\SecurityContext;

abstract class AbstractSecurityBlamer
{
    protected $security;

    public function __construct(SecurityContext $security = null)
    {
        $this->security = $security;
    }
}
