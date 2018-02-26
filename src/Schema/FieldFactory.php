<?php

namespace Nuwave\Lighthouse\Schema;

use GraphQL\Language\AST\FieldDefinitionNode;

class FieldFactory
{
    /**
     * Convert field definition to type.
     *
     * @param FieldDefinitionNode $field
     *
     * @return array
     */
    public static function convert(FieldDefinitionNode $field)
    {
        $resolver = directives()->hasResolver($field)
            ? directives()->fieldResolver($field)
            : static::resolver($field);

        // TODO: Wrap field middleware.
        return $resolver;
    }

    /**
     * Get default field resolver.
     *
     * @param FieldDefinitionNode $field
     *
     * @return \Closure
     */
    public static function resolver(FieldDefinitionNode $field)
    {
        return function ($parent, array $args) use ($field) {
            return data_get($parent, $field->name->value);
        };
    }
}