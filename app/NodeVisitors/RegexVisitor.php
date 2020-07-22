<?php


namespace App\NodeVisitors;


use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

class RegexVisitor extends NodeVisitorAbstract
{
    private $vulnInfo;
    private $varsRegex;

    public function __construct(\ArrayObject $vulnInfo, \ArrayObject $varsRegex)
    {
        $this->vulnInfo = $vulnInfo;
        $this->varsRegex = $varsRegex;

    }

    public function leaveNode(Node $node)
    {
        if
        (
            $node instanceof Node\Expr\Assign
            && $node->expr instanceof Node\Expr\ArrayDimFetch
            && $node->expr->var->name === '_GET'
        )
        {
            $this->varsRegex->append($node->var->name);
        }
        if
        (
            $node instanceof Node\Expr\FuncCall
            && in_array('preg_grep', $node->name->parts)
            && in_array($node->args[0]->value->name, (array)$this->varsRegex)
            && in_array($node->args[1]->value->name, (array)$this->varsRegex)
        )
        {
            $this->vulnInfo->append(array('vulnerability' => 'Regex',
                'status' => 'Proved',
                'startline' => $node->getStartLine(),
                'endline' => $node->getEndLine(),
                'rulenumber' => 3));
        }
        elseif (
            $node instanceof Node\Expr\FuncCall
            && in_array('preg_grep', $node->name->parts)
            && $node->args[0]->value instanceof Node\Expr\FuncCall
            && in_array('preg_quote',$node->args[0]->value->name->parts)
            && in_array($node->args[0]->value->args[0]->value->name, (array)$this->varsRegex)
            && in_array($node->args[1]->value->name, (array)$this->varsRegex)
        )
        {
            $this->vulnInfo->append(array('vulnerability' => 'Regex',
                'status' => 'Prevented',
                'startline' => $node->getStartLine(),
                'endline' => $node->getEndLine(),
                'rulenumber' => 3));
        }
    }
}