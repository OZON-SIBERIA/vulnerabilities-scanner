<?php


namespace App\NodeVisitors;


use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use App\NodeVisitors\SubExpressionXSSVisitor;

class ExpressionXSSVisitor extends NodeVisitorAbstract
{
    private $vulnInfo;
    private $varsXSS;
    private $stmts;

    public function __construct(\ArrayObject $vulnInfo, \ArrayObject $varsXSS, $stmts)
    {
        $this->varsXSS = $varsXSS;
        $this->vulnInfo = $vulnInfo;
        $this->stmts = $stmts;
    }

    public function leaveNode(Node $node)
    {

        if (
            $node instanceof Node\Expr\Assign
            && $node->expr instanceof Node\Expr\ArrayDimFetch
            && $node->expr->var->name === '_GET'
        )
        {
            $this->varsXSS->append(array('name' => $node->var->name,
                'startline' => $node->getStartLine(),
                'endline' => $node->getEndLine()));
        }

        if (
            !empty($this->varsXSS)
            && $node instanceof Node\Expr\FuncCall
            && in_array('htmlspecialchars', $node->name->parts)
        )
        {
            foreach ($node->args as $arg)
            {
                for($a = 0; $a<count($this->varsXSS); $a++)
                {
                    if($arg->value->name == $this->varsXSS[$a]['name'])
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
    public function afterTraverse(array $nodes)
    {
        $subtraverser = new NodeTraverser;
        $subtraverser->addVisitor(new SubExpressionXSSVisitor($this->vulnInfo, $this->varsXSS));
        $subtraverser->traverse($this->stmts);
    }
}