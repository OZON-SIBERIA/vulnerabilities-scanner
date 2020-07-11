<?php


namespace App\Service;

use App\NodeVisitors\EchoXSSVisitor;
use App\NodeVisitors\ExpressionXSSVisitor;
use App\NodeVisitors\HashVisitor;
use App\NodeVisitors\RegexVisitor;
use App\NodeVisitors\SQLVisitor;
use PhpParser\NodeTraverser;

class Analysis
{
    public function bigWalk($stmts): \ArrayObject
    {
        $traverser = new NodeTraverser;
        $vulnInfo = new \ArrayObject();
        $varsXSS = new \ArrayObject();
        $varsSQL = new \ArrayObject();
        $varsRegex = new \ArrayObject();


        $traverser->addVisitor(new EchoXSSVisitor($vulnInfo));
        $traverser->addVisitor(new ExpressionXSSVisitor($vulnInfo, $varsXSS, $stmts));
        $traverser->addVisitor(new SQLVisitor($vulnInfo, $varsSQL));
        $traverser->addVisitor(new HashVisitor($vulnInfo));
        $traverser->addVisitor(new RegexVisitor($vulnInfo, $varsRegex));
        $traverser->traverse($stmts);
        //var_dump($stmts);

        return $vulnInfo;
    }
}