<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\FuncCall;
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
        if ($expr instanceof Array_) {
            return ScalarType::ARRAY;
        }

        // @todo func call?
        if ($expr instanceof FuncCall) {
            return $this->resolveTypeFromFuncCall($expr);
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
                throw new NotImplementedYetException('Second arg is needed to resolve type');
            }

            $secondArgValue = $args[1]->value;

            if ($secondArgValue instanceof FuncCall) {
                $funcCallName = $this->resolveName($secondArgValue);

                if ($funcCallName === 'realpath') {
                    return ScalarType::STRING;
                }
            }
        }

        throw new NotImplementedYetException('Unable to resolve type from func call');
    }
}
