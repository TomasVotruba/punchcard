<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard;

use PhpParser\ConstExprEvaluator;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\Cast;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar;
use PhpParser\Node\Scalar\DNumber;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use TomasVotruba\PunchCard\Contracts\TypeInterface;
use TomasVotruba\PunchCard\Exception\NotImplementedYetException;
use TomasVotruba\PunchCard\Exception\ShouldNotHappenException;
use TomasVotruba\PunchCard\ValueObject\ConfigFile;
use TomasVotruba\PunchCard\ValueObject\Types\ArrayType;
use TomasVotruba\PunchCard\ValueObject\Types\BooleanType;
use TomasVotruba\PunchCard\ValueObject\Types\ClassStringType;
use TomasVotruba\PunchCard\ValueObject\Types\FloatType;
use TomasVotruba\PunchCard\ValueObject\Types\IntegerType;
use TomasVotruba\PunchCard\ValueObject\Types\MixedType;
use TomasVotruba\PunchCard\ValueObject\Types\StringType;
use Webmozart\Assert\Assert;

final class ParameterTypeResolver
{
    public function __construct(
        private readonly ConstExprEvaluator $constExprEvaluator,
    ) {
    }

    public function resolveFromExpr(Expr $expr, string $parameterName, ConfigFile $configFile): TypeInterface
    {
        if ($expr instanceof Scalar) {
            return $this->resolveScalar($expr);
        }

        if ($expr instanceof Array_) {
            $arrayItemType = new MixedType();
            foreach ($expr->items as $arrayItem) {
                Assert::isInstanceOf($arrayItem, ArrayItem::class);

                $arrayItemType = $this->resolveFromExpr($arrayItem->value, $parameterName, $configFile);
            }

            return new ArrayType($arrayItemType);
        }

        if ($expr instanceof FuncCall) {
            return $this->resolveTypeFromFuncCall($expr, $parameterName, $configFile);
        }

        if ($expr instanceof MethodCall) {
            return new MixedType();
        }

        if ($expr instanceof Cast && $expr instanceof Bool_) {
            return new BooleanType();
        }

        if ($expr instanceof Concat) {
            return new StringType();
        }

        if ($expr instanceof Expr\Ternary) {
            $ifType = null;
            if ($expr->if instanceof Expr) {
                $ifType = $this->resolveFromExpr($expr->if, $parameterName, $configFile);
            }
            $elseType = $this->resolveFromExpr($expr->else, $parameterName, $configFile);

            if ($ifType === null) {
                return $elseType;
            }

            if ($ifType::class === $elseType::class) {
                return $ifType;
            }
        }

        $classStringType = $this->resolveClassConstFetch($expr);
        if ($classStringType instanceof ClassStringType) {
            return $classStringType;
        }

        try {
            $realValue = $this->constExprEvaluator->evaluateDirectly($expr);
        } catch (\Throwable) {
            // nothing we can do
            return new MixedType();
        }

        if ($realValue === false || $realValue === true) {
            return new BooleanType();
        }

        if ($realValue === null) {
            return new MixedType();
        }

        throw new NotImplementedYetException(
            sprintf('The "%s" type is not implemented yet', $expr::class)
        );
    }

    private function resolveFuncCallName(FuncCall $funcCall): string
    {
        if ($funcCall->name instanceof Expr) {
            throw new ShouldNotHappenException($funcCall->name::class);
        }

        return $funcCall->name->toString();
    }

    private function resolveTypeFromFuncCall(FuncCall $funcCall, string $parameterName, ConfigFile $configFile): TypeInterface
    {
        $funcCallName = $this->resolveFuncCallName($funcCall);

        if ($funcCallName === 'env') {
            // look into 2nd argument as default, to get the type
            $args = $funcCall->getArgs();

            if (! isset($args[1])) {
                // fallback to most common type - @todo narrow by name if needed
                return new StringType(true);
            }

            $secondArgValue = $args[1]->value;

            if ($secondArgValue instanceof FuncCall) {
                $funcCallName = $this->resolveFuncCallName($secondArgValue);

                if ($funcCallName === 'realpath') {
                    return new StringType();
                }
            }

            $secondArgValueType = $this->resolveFromExpr($secondArgValue, $parameterName, $configFile);
            if ($secondArgValueType instanceof TypeInterface) {
                return $secondArgValueType;
            }

            //if ($secondArgValue instanceof Concat) {
            //    return new StringType();
            //}
            //
            //if ($secondArgValue instanceof Scalar) {
            //    return $this->resolveScalar($secondArgValue);
            //}

            //dump($secondArgValue);
        }

        if (str_ends_with($funcCallName, '_path')) {
            return new StringType();
        }

        if ($funcCallName === 'explode') {
            return new ArrayType(new StringType());
        }

        if ($funcCallName === 'array_filter') {
            return new ArrayType(new MixedType());
        }

        $errorMessage = sprintf('Unable to resolve type from "%s" func call', $funcCallName);
        throw new NotImplementedYetException($errorMessage);
    }

    private function resolveScalar(Scalar $scalar): TypeInterface
    {
        if ($scalar instanceof String_) {
            return new StringType();
        }

        if ($scalar instanceof LNumber) {
            return new IntegerType();
        }

        if ($scalar instanceof DNumber) {
            return new FloatType();
        }

        throw new NotImplementedYetException(sprintf(
            'The scalar type "%s" is not implemented yet',
            $scalar::class,
        ));
    }

    private function resolveClassConstFetch(Expr $expr): ?ClassStringType
    {
        if (! $expr instanceof ClassConstFetch) {
            return null;
        }

        if (! $expr->name instanceof Identifier) {
            return null;
        }

        $constantName = $expr->name->toString();
        if ($constantName !== 'class') {
            return null;
        }

        if (! $expr->class instanceof Name) {
            return null;
        }

        return new ClassStringType($expr->class->toString());
    }
}
