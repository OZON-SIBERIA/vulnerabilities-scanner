<?php


namespace App\NodeVisitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class EchoXSSVisitor extends NodeVisitorAbstract
{
    private $vulnInfo;

    public function __construct(\ArrayObject $vulnInfo)
    {
        $this->vulnInfo = $vulnInfo;
    }

    public function leaveNode(Node $node)
    {
        if (
            $node instanceof Node\Stmt\Echo_
        )
        {
            foreach ($node->exprs as $expr) {
                if (
                ($expr instanceof Node\Expr\ArrayDimFetch
                    && $expr->var->name === "_GET")
                    or
                ($expr instanceof Node\Expr\BinaryOp\Concat
                    && (($expr->left instanceof Node\Expr\ArrayDimFetch
                    && $expr->left->var->name === "_GET")
                    or ($expr->right instanceof Node\Expr\ArrayDimFetch
                    && $expr->right->var->name === "_GET")))
                )
                {
                    $this->vulnInfo->append(array('vulnerability' => 'XSS',
                        'status' => 'Proved',
                        'startline' => $node->getStartLine(),
                        'endline' => $node->getEndLine(),
                        'rulenumber' => 1));
                }
                elseif (
                    $expr instanceof Node\Expr\FuncCall
                    && in_array('htmlspecialchars',
                        $expr->name->parts)
                )
                {
                    $this->vulnInfo->append(array('vulnerability' => 'XSS',
                        'status' => 'Prevented',
                        'startline' => $node->getStartLine(),
                        'endline' => $node->getEndLine(),
                        'rulenumber' => 1));
                }
            }
        }
    }
}