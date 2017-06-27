<?php

namespace WsdlToPhp\PackageGenerator\Tests\Model;

use WsdlToPhp\PackageGenerator\Tests\TestCase;
use WsdlToPhp\PackageGenerator\Model\Service;

class StructAttributeTest extends TestCase
{
    /**
     *
     */
    public function testGetUniqueName()
    {
        $struct = StructTest::instance('Foo', true)->addAttribute('id', 'int')->addAttribute('name', 'string')->addAttribute('Name', 'string');
        $this->assertSame('id', $struct->getAttribute('id')->getUniqueName());
        $this->assertSame('name', $struct->getAttribute('name')->getUniqueName());
        $this->assertSame('Name_1', $struct->getAttribute('Name')->getUniqueName());
    }
    /**
     *
     */
    public function testGetReservedMethodsInstance()
    {
        $struct = StructTest::instance('Foo', true)->addAttribute('id', 'int');
        $this->assertInstanceOf('\WsdlToPhp\PackageGenerator\ConfigurationReader\StructReservedMethod', $struct->getAttribute('id')->getReservedMethodsInstance());
    }
    /**
     *
     */
    public function testGetUniqueNameWithConflict()
    {
        /**
         * previous context
         */
        $service = new Service(self::getBingGeneratorInstance(), 'Query');
        $service->addMethod('query', '', '');
        $service->getMethod('query')->getMethodName();
        /**
         * current context
         */
        $struct = StructTest::instance('query', true);
        $struct->addAttribute('query', 'string');
        $structAttribute = $struct->getAttribute('query');
        $this->assertSame(0, $structAttribute->getUniqueName());
        $this->assertSame(0, $structAttribute->getUniqueName());
        $this->assertSame('query', $structAttribute->getUniqueName('foo'));
        $this->assertSame('query', $structAttribute->getUniqueName('foo'));
        $this->assertSame('getQuery', $structAttribute->getGetterName());
        $this->assertSame('setQuery', $structAttribute->getSetterName());
    }
}
