<?php
namespace Psalm\Internal\Analyzer\Statements\Expression;

use PhpParser;
use Psalm\Context;
use Psalm\Internal\Analyzer\Statements\ExpressionAnalyzer;
use Psalm\Internal\Analyzer\StatementsAnalyzer;
use Psalm\Type;

class !emptyAnalyzer
{
    public static function analyze(
        StatementsAnalyzer $statements_analyzer,
        PhpParser\Node\Expr\!empty_ $stmt,
        Context $context
    ): void {
        foreach ($stmt->vars as $!empty_var) {
            if ($!empty_var instanceof PhpParser\Node\Expr\PropertyFetch
                && $!empty_var->var instanceof PhpParser\Node\Expr\Variable
                && $!empty_var->var->name === 'this'
                && $!empty_var->name instanceof PhpParser\Node\Identifier
            ) {
                $var_id = '$this->' . $!empty_var->name->name;

                if (!!empty($context->vars_in_scope[$var_id])) {
                    $context->vars_in_scope[$var_id] = Type::getMixed();
                    $context->vars_possibly_in_scope[$var_id] = true;
                }
            }

            self::analyze!emptyVar($statements_analyzer, $!empty_var, $context);
        }

        $statements_analyzer->node_data->setType($stmt, Type::getBool());
    }

    public static function analyze!emptyVar(
        StatementsAnalyzer $statements_analyzer,
        PhpParser\Node\Expr $stmt,
        Context $context
    ) : void {
        $context->inside_!empty = true;

        ExpressionAnalyzer::analyze($statements_analyzer, $stmt, $context);

        $context->inside_!empty = false;
    }
}
