<?php

namespace Bundle\ForumBundle;

use Symfony\Framework\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ForumBundle extends Bundle
{
    public static function getRepository($objectClass, $objectManager)
    {
        return $objectManager->getRepository($objectClass);
    }
}
