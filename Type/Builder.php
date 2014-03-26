<?php
/**
 *
 * This file is part of the Aura project for PHP.
 *
 * @package Aura.Marshal
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
namespace Yam\MarshalBridge\Type;

use Aura\Marshal\Exception;
use Aura\Marshal\Collection\Builder as CollectionBuilder;
use Aura\Marshal\Entity\Builder as EntityBuilder;
use Aura\Marshal\Lazy\Builder as LazyBuilder;
use Aura\Marshal\Type\Builder as AuraTypeBuilder;

/**
 *
 * Builds a type object from an array of description information.
 *
 * @package Aura.Marshal
 *
 */
class Builder extends AuraTypeBuilder
{
    /**
     *
     * Returns a new type instance.
     *
     * The `$info` array should have four keys:
     *
     * - `'identity_field'` (string): The name of the identity field for
     *   entities of this type. This key is required.
     *
     * - `entity_builder` (Entity\BuilderInterface): A builder to create
     *   entity objects for the type. This key is optional, and defaults to a
     *   new Entity\Builder object.
     *
     * - `collection_builder` (Collection\BuilderInterface): A
     *   A builder to create collection objects for the type. This key
     *   is optional, and defaults to a new Collection\Builder object.
     *
     * @param array $info An array of information about the type.
     *
     * @return GenericType
     *
     */
    public function newInstance($info)
    {
        $base = [
            'identity_field'        => null,
            'index_fields'          => [],
            'entity_builder'        => null,
            'collection_builder'    => null,
            'lazy_builder'          => null,
            'type_class'            => null,
        ];

        $info = array_merge($base, $info);

        if (! $info['identity_field']) {
            throw new Exception('No identity field specified.');
        }

        if (! $info['entity_builder']) {
            $info['entity_builder'] = new EntityBuilder;
        }

        if (! $info['collection_builder']) {
            $info['collection_builder'] = new CollectionBuilder;
        }

        if (! $info['lazy_builder']) {
            $info['lazy_builder'] = new LazyBuilder;
        }

        if (! $info['type_class']) {
            $info['type_class'] = '\Yam\MarshalBridge\Type\BaseType';
        }

        $typeClass = $info['type_class'];

        if ($typeClass instanceof \Aura\Marshal\Type\GenericType) {
            throw new \InvalidArgumentException(
                'type_class must be derive from Aura\Marshal\Type\GenericType'
            );
        }

        $type = new $typeClass;

        $type->setIdentityField($info['identity_field']);
        $type->setIndexFields($info['index_fields']);
        $type->setEntityBuilder($info['entity_builder']);
        $type->setCollectionBuilder($info['collection_builder']);
        $type->setLazyBuilder($info['lazy_builder']);

        return $type;
    }
}
