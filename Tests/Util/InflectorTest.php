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

        if (function_exists('iconv')) {
            $this->assertEquals('mr-francois-dupont', Inflector::slugify('Mr. François Dupont'));
            $this->assertEquals('le-numero-de-telephone', Inflector::slugify('Le numéro de téléphone'));
        } else {
            $this->markTestSkipped('Removing accents: iconv not installed');
        }
    }

}