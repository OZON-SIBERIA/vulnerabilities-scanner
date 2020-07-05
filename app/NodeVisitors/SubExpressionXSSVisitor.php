<?php


namespace App\NodeVisitors;


use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class SubExpressionXSSVisitor extends NodeVisitorAbstract
{
    private $vulnInfo;
    private $varsXSS;


    public function __construct(\ArrayObject $vulnInfo, \ArrayObject $varsXSS)
    {
        $this->vulnInfo = $vulnInfo;
        $this->vars = $varsXSS;
    }

    public function leaveNode(Node $node)
    {
        for($a = 0; $a<count($this->varsXSS); $a++)
        {
            if (
                $node instanceof Node\Stmt\Echo_
            )
            {
                foreach ($node->exprs as $expr)
                {
                    if (
                        $expr->name === $this->varsXSS[$a]['name']
                        or ($expr instanceof Node\Expr\BinaryOp\Concat
                        && ($expr->left->name === $this->varsXSS[$a]['name']
                        or $expr->right->name === $this->varsXSS[$a]['name']))
                    )
                    {
                        $this->vulnInfo->append(array('status' => 'XSSproved',
                            'startline' => $this->varsXSS[$a]['startline'],
                            'endline' => $this->varsXSS[$a]['endline'],
                            'rulenumber' => 1));
                        $this->varsXSS->offsetUnset($a);
                    }
                }

            }
        }
    }
}
