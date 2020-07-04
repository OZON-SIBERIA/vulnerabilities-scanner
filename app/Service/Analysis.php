<?php


namespace App\Service;

use App\NodeVisitors\EchoXSSVisitor;
use App\NodeVisitors\ExpressionXSSVisitor;
use PhpParser\NodeTraverser;

class Analysis
{
    public function bigWalk($stmts): \ArrayObject
    {
        $traverser = new NodeTraverser;
        $vulnInfo = new \ArrayObject();
        $vars = new \ArrayObject();


        $traverser->addVisitor(new EchoXSSVisitor($vulnInfo));
        $traverser->addVisitor(new ExpressionXSSVisitor($vulnInfo, $vars, $stmts));
        $traverser->traverse($stmts);
        //var_dump($stmts);


        return $vulnInfo;
    }
}