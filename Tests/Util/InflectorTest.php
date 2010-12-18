<?php

namespace Bundle\SosForum\CoreBundle\Tests\Util;

use Bundle\SosForum\CoreBundle\Util\Inflector;

class InflectorTest extends \PHPUnit_Framework_TestCase
{

    public function testSlugify()
    {
        $this->assertEmpty(Inflector::slugify(''));
        $this->assertEquals('foo-bar', Inflector::slugify('Foo Bar'));
        $this->assertEquals('foo-bar', Inflector::slugify('Foo      Bar'));
        $this->assertEquals('foo-bar', Inflector::slugify('    Foo Bar'));
        $this->assertEquals('foo-bar', Inflector::slugify('Foo Bar     '));
        $this->assertEquals('foo-bar', Inflector::slugify('Foo-Bar'));
        $this->assertEquals('foo-bar', Inflector::slugify('Foo / Bar'));
        $this->assertEquals('foo-bar', Inflector::slugify('Foo Bar ...'));
    }

}
