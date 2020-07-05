<?php


namespace App\NodeVisitors;


use App\NodeVisitors\SubRegexVisitor;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

class RegexVisitor extends NodeVisitorAbstract
{
    private $vulnInfo;
    private $varsRegex;
    private $stmts;

    public function __construct(\ArrayObject $vulnInfo, \ArrayObject $varsRegex, $stmts)
    {
        $this->vulnInfo = $vulnInfo;
        $this->varsRegex = $varsRegex;
        $this->stmts = $stmts;

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
            $this->vulnInfo->append(array('status' => 'RegexProved',
                'startline' => $node->getStartLine(),
                'endline' => $node->getEndLine(),
                'rulenumber' => 4));
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
            $this->vulnInfo->append(array('status' => 'RegexPrevented',
                'startline' => $node->getStartLine(),
                'endline' => $node->getEndLine(),
                'rulenumber' => 4));
        }
    }
}