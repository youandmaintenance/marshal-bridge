<?php

/**
 * This File is part of the Yam\MarshalBridge\Collection package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\MarshalBridge\Collection;

use \Yam\Utils\Traits\Getter;
use \Illuminate\Support\Contracts\JsonableInterface;
use \Illuminate\Support\Contracts\ArrayableInterface;
use \Aura\Marshal\Collection\GenericCollection as MarshalCollection;

/**
 * @class AbstractCollection extends MarshalCollection implements CollectionInterface
 * @see CollectionInterface
 * @see MarshalCollection
 *
 * @package Yam\MarshalBridge\Collection
 * @version $Id$
 * @author Thomas Appel <mail@thomas-appel.com>
 * @license MIT
 */
abstract class AbstractCollection extends MarshalCollection implements CollectionInterface, JsonableInterface, ArrayableInterface
{
    use Getter;

    /**
     * identityKey
     *
     * @var mixed
     */
    protected $identityKey;

    /**
     * @param array $data
     * @param mixed $key
     *
     * @access public
     */
    public function __construct(array $data = [], $key = null)
    {
        $this->identityKey = $key;
        parent::__construct($data);
    }

    /**
     * setIdentityKey
     *
     * @param mixed $key
     *
     * @access public
     * @return void
     */
    public function setIdentityKey($key)
    {
        $this->identityKey = $this->identityKey ?: $key;
    }

    /**
     * getItentityKey
     *
     *
     * @access protected
     * @return string
     */
    public function getIdentityKey()
    {
        return $this->identityKey;
    }

    /**
     * pluck
     *
     * @param mixed $attribute
     *
     * @access public
     * @return mixed
     */
    public function pluck($attribute)
    {
        return array_pluck($this->data, $attribute);
    }

    /**
     * find
     *
     * @param mixed $id
     *
     * @access public
     * @return mixed
     */
    public function find($id)
    {
        if (null === ($key = $this->getIdentityKey())) {
            throw new \BadMethodCallException('no iditentiy key is set');
            return;
        }

        foreach ($this->data as $data) {
            if ($this->getItemAttributeValue($data, $key) === $id) {
                return $data;
            }
        }
    }

    /**
     * filter
     *
     * @param mixed $attribute
     * @param mixed $value
     *
     * @access public
     * @return array
     */
    public function filter($attribute, $value)
    {
        $result = array_filter($this->data, function ($data) use ($attribute, $value) {
            return $this->getItemAttributeValue($data, $attribute) === $value;
        });

        return new static((array)$result, $this->getIdentityKey());
    }

    /**
     * replace
     *
     * @param GenericCollection $collection
     *
     * @access public
     * @return void
     */
    public function replace(CollectionInterface $collection)
    {
        $this->data = $collection->getData();
    }

    /**
     * getData
     *
     * @access public
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * toArray
     *
     * @access public
     * @return array
     */
    public function toArray()
    {
        $data = [];

        foreach ($this->data as $key => $entity) {
            if ($entity instanceof ArrayableInterface) {
                $value = $entity->toArray();
            } elseif (is_object($entity)) {
                $value = (array)$entity;
            } else {
                $value = $entity;
            }
            $data[$key] = $value;
        }

        return $data;
    }

    /**
     * toJson
     *
     * @param int $options
     *
     * @access public
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * getItemAttributeValue
     *
     * @param mixed $item
     * @param mixed $attribute
     *
     * @access protected
     * @return mixed
     */
    protected function getItemAttributeValue($item, $attribute)
    {
        return is_object($item) ? $item->{$attribute} : $item[$attribute];
    }
}
