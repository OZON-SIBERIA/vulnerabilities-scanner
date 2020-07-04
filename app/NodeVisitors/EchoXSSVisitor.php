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
        ) {
            foreach ($node->exprs as $expr) {
                if (
                    $expr instanceof Node\Expr\ArrayDimFetch
                    && $expr->var->name === "_GET"
                )
                {
                    $this->vulnInfo->append(array('status' => 'XSSproved',
                        'startline' => $node->getStartLine(),
                        'endline' => $node->getEndLine()));
                }
                elseif (
                    $expr instanceof Node\Expr\FuncCall
                    && in_array('htmlspecialchars', $expr->name->parts)
                )
                {
                    $this->vulnInfo->append(array('status' => 'XSSprevented',
                        'startline' => $node->getStartLine(),
                        'endline' => $node->getEndLine()));
                }
            }
        }
    }
}