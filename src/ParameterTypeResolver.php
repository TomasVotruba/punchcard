<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Cast;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\ConstExprEvaluator;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Scalar;
use PhpParser\Node\Scalar\DNumber;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use TomasVotruba\PunchCard\Enum\ScalarType;
use TomasVotruba\PunchCard\Exception\NotImplementedYetException;
use TomasVotruba\PunchCard\Exception\ShouldNotHappenException;

final class ParameterTypeResolver
{
    /**
     * @return ScalarType::*
     */
    public function resolveExpr(Expr $expr): string
    {
        if ($expr instanceof Scalar) {
            return $this->resolveScalar($expr);
        }

        if ($expr instanceof Array_) {
            return ScalarType::ARRAY;
        }

        // @todo func call?
        if ($expr instanceof FuncCall) {
            return $this->resolveTypeFromFuncCall($expr);
        }

        $constExprEvaluator = new ConstExprEvaluator();

        if ($expr instanceof MethodCall) {
            // @todo resolve later
            return ScalarType::MIXED;
        }

        if ($expr instanceof Cast && $expr instanceof Bool_) {
            return ScalarType::BOOLEAN;
        }

        $realValue = $constExprEvaluator->evaluateDirectly($expr);
        if ($realValue === false || $realValue === true) {
            return ScalarType::BOOLEAN;
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

    /**
     * @return ScalarType::*
     */
    private function resolveTypeFromFuncCall(FuncCall $funcCall): string
    {
        $funcCallName = $this->resolveFuncCallName($funcCall);

        if ($funcCallName === 'env') {
            // look into 2nd argument as default, to get the type
            $args = $funcCall->getArgs();

            if (! isset($args[1])) {
                // fallback to most common type - @todo narrow by name if needed
                return ScalarType::STRING;
            }

            $secondArgValue = $args[1]->value;

            if ($secondArgValue instanceof FuncCall) {
                $funcCallName = $this->resolveFuncCallName($secondArgValue);

                if ($funcCallName === 'realpath') {
                    return ScalarType::STRING;
                }
            }

            if ($secondArgValue instanceof Concat) {
                return ScalarType::STRING;
            }

            if ($secondArgValue instanceof Scalar) {
                return $this->resolveScalar($secondArgValue);
            }
        }

        if ($funcCallName === 'storage_path') {
            return ScalarType::STRING;
        }

        $errorMessage = sprintf('Unable to resolve type from "%s" func call', $funcCallName);
        throw new NotImplementedYetException($errorMessage);
    }

    /**
     * @return ScalarType::*
     */
    private function resolveScalar(Scalar $scalar): string
    {
        if ($scalar instanceof String_) {
            return ScalarType::STRING;
        }

        if ($scalar instanceof LNumber) {
            return ScalarType::INTEGER;
        }

        if ($scalar instanceof DNumber) {
            return ScalarType::FLOAT;
        }

        throw new NotImplementedYetException(sprintf(
            'The scalar type "%s" is not implemented yet',
            $scalar::class,
        ));
    }
}
