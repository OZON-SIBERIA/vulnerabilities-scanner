<?php


namespace App\NodeVisitors;


use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

class ExpressionXSSVisitor extends NodeVisitorAbstract
{
    private $vulnInfo;
    private $vars;
    private $stmts;

    public function __construct(\ArrayObject $vulnInfo, \ArrayObject $vars, $stmts)
    {
        $this->vars = $vars;
        $this->vulnInfo = $vulnInfo;
        $this->stmts = $stmts;
    }

    public function leaveNode(Node $node)
    {
        if (
            $node instanceof Node\Stmt\Expression
            && $node->expr instanceof Node\Expr\Assign
            && $node->expr->expr->var->name === "_GET"
        )
        {
            $this->vars->append(array('name' => $node->expr->var->name,
                'startline' => $node->getStartLine(),
                'endline' => $node->getEndLine()));
        }

        if (
            !empty($this->vars)
            && $node instanceof Node\Expr\FuncCall
            && in_array('htmlspecialchars', $node->name->parts)
        )
        {
            foreach ($node->args as $arg)
            {
                for($a = 0; $a<count($this->vars); $a++)
                {
                    if($arg->value->name == $this->vars[$a]['name'])
                    {
                        $this->vulnInfo->append(array('status' => 'XSSprevented',
                            'startline' => $this->vars[$a]['startline'],
                            'endline' => $this->vars[$a]['endline']));
                        $this->vars->offsetUnset($a);
                    }
                }

            }
        }
    }
    public function afterTraverse(array $nodes)
    {
        $subtraverser = new NodeTraverser;
        $subtraverser->addVisitor(new SubExpressionXSSVisitor($this->vulnInfo, $this->vars));
        $subtraverser->traverse($this->stmts);
    }
}