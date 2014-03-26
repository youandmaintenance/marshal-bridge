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

use \Yam\MarshalBridge\IdentityAwareInterface;

/**
 * @interface CollectionInterface extends IdentityAwareInterface
 * @see IdentityAwareInterface
 *
 * @package Yam\MarshalBridge\Collection
 * @version $Id$
 * @author Thomas Appel <mail@thomas-appel.com>
 * @license MIT
 */
interface CollectionInterface extends IdentityAwareInterface
{
    /**
     * find
     *
     * @param mixed $identityKey
     *
     * @access public
     * @return mixed
     */
    public function find($identityKey);

    /**
     * pluck
     *
     * @param mixed $attribute
     *
     * @access public
     * @return array
     */
    public function pluck($attribute);

    /**
     * filter
     *
     * @param mixed $attribute
     * @param mixed $value
     *
     * @access public
     * @return array
     */
    public function filter($attribute, $value);

    /**
     * replace
     *
     * @param CollectionInterface $collection
     *
     * @access public
     * @return array
     */
    public function replace(CollectionInterface $collection);

    /**
     * getData
     *
     * @access public
     * @return array
     */
    public function getData();
}
