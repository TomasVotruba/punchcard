<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\NodeFactory;

use PhpParser\Comment\Doc;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
use TomasVotruba\PunchCard\Enum\ScalarType;
use TomasVotruba\PunchCard\ValueObject\ParameterAndType;

final class PropertyFactory
{
    public function create(ParameterAndType $parameterAndType): Property
    {
        $propertyProperty = new PropertyProperty($parameterAndType->getName());

        $property = new Property(Class_::MODIFIER_PRIVATE, [$propertyProperty]);
        $property->type = new Identifier($parameterAndType->getType());

        if ($parameterAndType->getType() === ScalarType::ARRAY) {
            $property->props[0]->default = new Array_([]);

            // so far just string[], improve later on with types
            $property->setDocComment(new Doc("/**\n * @var string[]\n */"));
        }

        return $property;
    }
}
