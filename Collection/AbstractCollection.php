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
class AbstractCollection extends MarshalCollection implements CollectionInterface
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
        $this->identityKey = $key;
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
        foreach ($this->data as $data) {
            if ($this->getDefault($data, $this->identityKey, false) === $id) {
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
        return array_filter($this->data, function ($data) use ($attribute, $value) {
            return isset($data[$attribute]) && $data[$attribute] === $value;
        });
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
}
