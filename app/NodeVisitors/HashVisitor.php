<?php


namespace App\NodeVisitors;


use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class HashVisitor extends NodeVisitorAbstract
{
    private $vulnInfo;

    public function __construct(\ArrayObject $vulnInfo)
    {
        $this->vulnInfo = $vulnInfo;
    }

    public function leaveNode(Node $node)
    {
        if(
        ($node instanceof Node\Expr\FuncCall
            && $node->name->parts === "md5")
        or
        ($node instanceof Node\Expr\FuncCall
            && $node->name->parts === "sha1")
        )
        {
            $this->vulnInfo->append(array('status' => 'HashProved',
                'startline' => $node->getStartLine(),
                'endline' => $node->getEndLine(),
                'rulenumber' => 3));
        }
        if
        (
            $node instanceof Node\Expr\FuncCall
            && in_array('password_hash', $node->name->parts)
        )
        {
            foreach ($node->args as $arg)
            {
                if
                (
                    $arg->value instanceof Node\Expr\ConstFetch
                    && in_array('PASSWORD_BCRYPT', $arg->value->name->parts)
                )
                {
                    $this->vulnInfo->append(array('status' => 'HashPrevented',
                        'startline' => $node->getStartLine(),
                        'endline' => $node->getEndLine(),
                        'rulenumber' => 3));
                }
            }
        }
    }
}