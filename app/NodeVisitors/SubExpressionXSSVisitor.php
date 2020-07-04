<?php


namespace App\NodeVisitors;


use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class SubExpressionXSSVisitor extends NodeVisitorAbstract
{
    private $vulnInfo;
    private $vars;


    public function __construct(\ArrayObject $vulnInfo, \ArrayObject $vars)
    {
        $this->vulnInfo = $vulnInfo;
        $this->vars = $vars;
    }

    public function leaveNode(Node $node)
    {
        for($a = 0; $a<count($this->vars); $a++)
        {
            if (
                $node instanceof Node\Stmt\Echo_
            )
            {
                foreach ($node->exprs as $expr)
                {
                    if ($expr->name === $this->vars[$a]['name'])
                    {
                        $this->vulnInfo->append(array('status' => 'XSSproved',
                            'startline' => $this->vars[$a]['startline'],
                            'endline' => $this->vars[$a]['endline']));
                        $this->vars->offsetUnset($a);
                    }
                }

            }
        }
    }
}
