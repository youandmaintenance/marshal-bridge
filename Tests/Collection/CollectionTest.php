<?php

/**
 * This File is part of the Yam\MarshalBridge package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\MarshalBridge\Tests\Collection;

use Yam\MarshalBridge\Collection\AbstractCollection;
use Yam\MarshalBridge\Tests\Collection\Stubs\CollectionStub as Collection;

/**
 * @class CollectionTest extends \PHPUnit_Framework_TestCase
 * @see \PHPUnit_Framework_TestCase
 *
 * @package Yam\MarshalBridge
 * @version $Id$
 * @author Thomas Appel <mail@thomas-appel.com>
 * @license MIT
 */
class CollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function itShouldBeInstantiable()
    {
        $collection = new Collection;
        $this->assertInstanceof('Yam\MarshalBridge\Collection\AbstractCollection', $collection);
    }

    /**
     * @test
     */
    public function isShouldFindAnItemByItsPrimaryKey()
    {
        $objA = new \StdClass();
        $objA->id = 12;
        $objB = new \StdClass();
        $objB->id = 22;
        $objC = new \StdClass();
        $objC->id = 42;

        $data = [
            $objA,
            $objB,
            $objC
        ];

        $collection = new Collection($data, 'id');
        $this->assertSame($objB, $collection->find(22));

        $objA = new \StdClass();
        $objA->uuid = 12;
        $objB = new \StdClass();
        $objB->uuid = 22;
        $objC = new \StdClass();
        $objC->uuid = 42;

        $data = [
            $objA,
            $objB,
            $objC
        ];

        $collection = new Collection($data);
        $collection->setIdentityKey('uuid');
        $this->assertSame($objB, $collection->find(22));
    }

    /**
     * @test
     */
    public function itShouldYellIfFindWasCalledAndNoPrimaryKeyIsSet()
    {
        $collection = new Collection([]);
        try {
            $collection->find(42);
            $this->fail('this should not pass');
        } catch (\BadMethodCallException $e) {
            $this->assertInstanceof('BadMethodCallException', $e);
            return;
        }

        $this->fail('o_O');
    }

    /**
     * @test
     */
    public function identityKeyShouldBeImmutableOnceItIsSet()
    {
        $collection = new Collection([], 'id');
        $collection->setIdentityKey('uuid');

        $this->assertSame('id', $collection->getIdentityKey());
    }

    /**
     * @test
     */
    public function itShouldBeCapableOfFilteringItemsByAttribute()
    {
        $objA = new \StdClass();
        $objA->name = 'test';
        $objB = new \StdClass();
        $objB->name = 'no test';
        $objC = new \StdClass();
        $objC->name = 'test';

        $data = [
            $objA,
            $objB,
            $objC
        ];

        $collection = new Collection($data);
        $result = $collection->filter('name', 'test')->getData();

        $this->assertTrue(in_array($objA, $result));
        $this->assertTrue(in_array($objC, $result));
        $this->assertFalse(in_array($objB, $result));
    }

    /**
     * @test
     */
    public function itShouldColumnizePluckedValues()
    {
        $objA = new \StdClass();
        $objA->id = 12;
        $objB = new \StdClass();
        $objB->id = 22;
        $objC = new \StdClass();
        $objC->id = 42;

        $data = [
            $objA,
            $objB,
            $objC
        ];

        $collection = new Collection($data);
        $this->assertSame([12, 22, 42], $collection->pluck('id'));
    }

    /**
     * @test
     */
    public function itShouldBeArrayable()
    {
        $data = [
            new \StdClass
        ];
        $data[0]->name = 'foo';

        $collection = new Collection($data);

        $this->assertSame([['name' => 'foo']], $collection->toArray());
    }

    /**
     * @test
     */
    public function getDataSouldReturnRawData()
    {
        $data = [
            new \StdClass
        ];
        $data[0]->name = 'foo';

        $collection = new Collection($data);

        $this->assertSame($data, $collection->getData());
    }
}
