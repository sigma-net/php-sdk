<?php


namespace Tests\SigmaNet\SDK\Utils;


use SigmaNet\SDK\Utils\AccessorUtil;
use PHPUnit\Framework\TestCase;

class AccessorUtilTest extends TestCase
{
    private $properties = [
        'property' => 'property',
        'property_property' => 'propertyProperty',
        'property_property_value' => 'propertyPropertyValue',
        'some_val_' => 'someVal',
        'CrAzY_cAse' => 'crazyCase',
    ];

    private $getters = [
        'property' => 'getProperty',
        'property_property' => 'getPropertyProperty',
        'property_property_value' => 'getPropertyPropertyValue',
        'some_val_' => 'getSomeVal',
        'CrAzY_cAse' => 'getCrazyCase',
    ];

    private $adder = [
        'property' => 'addProperty',
        'property_property' => 'addPropertyProperty',
        'property_property_value' => 'addPropertyPropertyValue',
        'some_val_' => 'addSomeVal',
        'CrAzY_cAse' => 'addCrazyCase',
    ];

    public function testProperty()
    {
        foreach ($this->properties as $key => $except) {
            $this->assertEquals($except, AccessorUtil::property($key));
        }
    }

    public function testGetter()
    {
        foreach ($this->getters as $key => $except) {
            $this->assertEquals($except, AccessorUtil::getter($key));
        }
    }

    public function testAdder()
    {
        foreach ($this->adder as $key => $except) {
            $this->assertEquals($except, AccessorUtil::adder($key));
        }
    }
}
