<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\NodeFactory;

use PhpParser\Comment\Doc;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
use TomasVotruba\PunchCard\Enum\ScalarType;
use TomasVotruba\PunchCard\ValueObject\ParameterAndType;

final class PropertyFactory
{
    public function create(ParameterAndType $parameterAndType): Property
    {
        $propertyProperty = new PropertyProperty($parameterAndType->getVariableName());

        $property = new Property(Class_::MODIFIER_PRIVATE, [$propertyProperty]);

        // property is always nullable if string, unless special name
        $property->type = new Identifier($parameterAndType->getPropertyTypeDeclaration());

        if ($parameterAndType->isArrayType()) {
            $property->props[0]->default = new Array_([]);

            // so far just string[], improve later on with types
            $property->setDocComment(new Doc(sprintf(
                "/**\n * @var %s\n */",
                $parameterAndType->getPropertyType()
            )));
        } elseif ($parameterAndType->isPropertyNullableType()) {
            $property->props[0]->default = new ConstFetch(new Name('null'));
        } elseif ($parameterAndType->getPropertyType() === ScalarType::BOOLEAN) {
            $property->props[0]->default = new ConstFetch(new Name('false'));
        }

        return $property;
    }
}
