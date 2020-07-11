<?php


namespace App\NodeVisitors;


use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class SQLVisitor extends NodeVisitorAbstract
{
    private $vulnInfo;
    private $varsSQL;

    public function __construct(\ArrayObject $vulnInfo, \ArrayObject $varsSQL)
    {
        $this->vulnInfo = $vulnInfo;
        $this->varsSQL = $varsSQL;
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
            $this->varsSQL->append(array('name' => $node->var->name,
                'startline' => $node->getStartLine()));
        }
        if
        (
            !empty($this->varsSQL)
            && $node instanceof Node\Expr\FuncCall
            && in_array('mysql_query', $node->name->parts)
        )
        {
            foreach ($node->args as $arg)
            {
                for ($a = 0; $a<count($this->varsSQL); $a++)
                {
                    if(
                        $arg->value instanceof Node\Expr\BinaryOp\Concat
                        && $arg->value->right->name === $this->varsSQL[$a]['name']
                )
                    {
                        $this->vulnInfo->append(array('vulnerability' => 'SQL',
                            'status' => 'Proved',
                            'startline' => $this->varsSQL[$a]['startline'],
                            'endline' => $node->getEndLine(),
                            'rulenumber' => 2));
                    }
                }
            }
        }
    }

}