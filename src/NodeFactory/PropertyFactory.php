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
use TomasVotruba\PunchCard\ValueObject\ParameterTypeAndDefaultValue;
use TomasVotruba\PunchCard\ValueObject\Types\BooleanType;

final class PropertyFactory
{
    public function create(ParameterTypeAndDefaultValue $parameterTypeAndDefaultValue): Property
    {
        $propertyProperty = new PropertyProperty($parameterTypeAndDefaultValue->getVariableName());

        $property = new Property(Class_::MODIFIER_PRIVATE, [$propertyProperty]);

        // property is always nullable if string, unless special name
        $property->type = new Identifier($parameterTypeAndDefaultValue->getPropertyTypeDeclaration());

        if ($parameterTypeAndDefaultValue->isArrayType()) {
            $property->props[0]->default = new Array_([]);

            // so far just string[], improve later on with types
            $property->setDocComment(new Doc(sprintf(
                "/**\n * @var %s\n */",
                $parameterTypeAndDefaultValue->renderPropertyTypeDoc()
            )));
        } elseif ($parameterTypeAndDefaultValue->isPropertyNullableType()) {
            $property->props[0]->default = new ConstFetch(new Name('null'));
        } elseif ($parameterTypeAndDefaultValue->getPropertyType() instanceof BooleanType) {
            $property->props[0]->default = new ConstFetch(new Name('false'));
        }

        return $property;
    }
}
