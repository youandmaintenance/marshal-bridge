<?php

/**
 * This File is part of the Yam\MarshalBridge package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\MarshalBridge;

use \Aura\Marshal\Manager;
use \Aura\Marshal\Type\Builder as TypeBuilder;
use \Aura\Marshal\Relation\Builder as RelationBuilder;
use \Illuminate\Support\ServiceProvider;


/**
 * @class MarshalBridgeServiceProvider
 *
 * @package Yam\MarshalBridge
 * @version $Id$
 * @author Thomas Appel <mail@thomas-appel.com>
 * @license MIT
 */
class MarshalBridgeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bindShared(
            'marshal.manager',
            function () {
                return new \Aura\Marshal\Manager(new TypeBuilder, new RelationBuilder);
            }
        );
    }
}
