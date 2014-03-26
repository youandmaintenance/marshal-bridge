<?php

/**
 * This File is part of the Yam\MarshalBridge\Collection package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\MarshalBridge;

/**
 * @interface IdentityAwareInterface
 *
 * @package Yam\MarshalBridge
 * @version $Id$
 * @author Thomas Appel <mail@thomas-appel.com>
 * @license MIT
 */
interface IdentityAwareInterface
{
    public function setIdentityKey($key);
}
