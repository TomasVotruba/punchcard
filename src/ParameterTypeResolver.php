<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard;

use PhpParser\ConstExprEvaluator;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\FuncCall;
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
        if ($expr instanceof String_) {
            return ScalarType::STRING;
        }

        if ($expr instanceof Array_) {
            return ScalarType::ARRAY;
        }

        // @todo func call?
        if ($expr instanceof FuncCall) {
            return $this->resolveTypeFromFuncCall($expr);
        }

        $constExprEvaluator = new ConstExprEvaluator();
        $realValue = $constExprEvaluator->evaluateDirectly($expr);
        if ($realValue === false || $realValue === true) {
            return ScalarType::BOOLEAN;
        }

        throw new NotImplementedYetException(
            sprintf('The "%s" type is not implemented yet', $expr::class)
        );
    }

    private function resolveName(FuncCall $funcCall): string
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
        $funcCallName = $this->resolveName($funcCall);

        if ($funcCallName === 'env') {
            // look into 2nd argument as default, to get the type
            $args = $funcCall->getArgs();

            if (! isset($args[1])) {
                // fallback to most common type - @todo narrow by name if needed
                return ScalarType::STRING;
            }

            $secondArgValue = $args[1]->value;

            if ($secondArgValue instanceof FuncCall) {
                $funcCallName = $this->resolveName($secondArgValue);

                if ($funcCallName === 'realpath') {
                    return ScalarType::STRING;
                }
            }

            if ($secondArgValue instanceof String_) {
                return ScalarType::STRING;
            }

            if ($secondArgValue instanceof LNumber) {
                return ScalarType::INTEGER;
            }

            if ($secondArgValue instanceof Expr\BinaryOp\Concat) {
                return ScalarType::STRING;
            }
        }

        if ($funcCallName === 'storage_path') {
            return ScalarType::STRING;
        }

        $errorMessage = sprintf('Unable to resolve type from "%s" func call', $funcCallName);
        throw new NotImplementedYetException($errorMessage);
    }
}
