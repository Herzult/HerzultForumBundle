<?php

namespace Bundle\SosForum\CoreBundle\Blamer;

use Symfony\Component\Security\SecurityContext;

abstract class AbstractSecurityBlamer
{
    protected $security;

    public function __construct(SecurityContext $security = null)
    {
        $this->security = $security;
    }
}
