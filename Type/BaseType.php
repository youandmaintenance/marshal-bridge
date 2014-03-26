<?php

/**
 * This File is part of the Yam\MarshalBridge\Type package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\MarshalBridge\Type;

use \Aura\Marshal\Type\GenericType;
use \Yam\MarshalBridge\IdentityAwareInterface;

/**
 * @class BaseType
 * @package Yam\MarshalBridge\Type
 * @version $Id$
 */
class BaseType extends GenericType
{
    /**
     * {@inheritdoc}
     */
    public function getCollection(array $identity_values)
    {
        $collection = parent::getCollection($identity_values);

        $this->setCollectionIdKey($collection);

        return $collection;
    }

    /**
     * loadCollection
     *
     * @param array $data
     *
     * @access public
     * @return mixed
     */
    public function loadCollection(array $data)
    {
        $collection = parent::loadCollection($data);

        $this->setCollectionIdKey($collection);

        return $collection;
    }

    /**
     * getCollectionByField
     *
     * @param mixed $field
     * @param mixed $values
     *
     * @access public
     * @return mixed
     */
    public function getCollectionByField($field, $values)
    {
        $collection = parent::getCollectionByField($field, $values);

        $this->setCollectionIdKey($collection);

        return $collection;
    }

    /**
     * getCollectionByIndex
     *
     * @param mixed $field
     * @param mixed $values
     *
     * @access protected
     * @return mixed
     */
    protected function getCollectionByIndex($field, $values)
    {
        $collection = parent::getCollectionByIndex($field, $values);

        $this->setCollectionIdKey($collection);

        return $collection;
    }

    /**
     * setCollectionIdKey
     *
     * @param mixed $collection
     *
     * @access protected
     * @return mixed
     */
    protected function setCollectionIdKey($collection)
    {
        if ($collection instanceof IdentityAwareInterface) {
            $collection->setIdentityKey($this->identity_field);
        }
    }
}
