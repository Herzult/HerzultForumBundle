<?php

namespace Bundle\SosForum\CoreBundle\Tests\Model;

use Bundle\SosForum\CoreBundle\Test\WebTestCase;

class MetadataTest extends WebTestCase
{

    public function testGetAllMetadata()
    {
        $om = $this->getService('forum.object_manager');

        try {
            $allClasses = $om->getMetadataFactory()->getAllMetadata();
        } catch (\Exception $e) {
            $this->fail(sprintf('%s %s', get_class($e), $e->getMessage()));
        }

        $this->assertFalse(empty($allClasses));
    }

}
