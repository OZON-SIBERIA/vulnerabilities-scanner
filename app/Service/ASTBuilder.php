<?php


namespace App\Service;
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;

class ASTBuilder
{

    public static function prepare($code)
    {
        $code = $code['code'];
        return  <<<CODE
{$code}
CODE;
    }

    public static function toAST($code){
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $ast = $parser->parse($code);
        return $ast;
    }
}