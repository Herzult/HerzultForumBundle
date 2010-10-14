<?php

namespace Bundle\ForumBundle\Tests\Util;

use Bundle\ForumBundle\Util\Inflector;

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
