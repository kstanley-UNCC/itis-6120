<?php

namespace Itis6120\Project2\Doctrine\ORM\Query\AST\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class StafferAuthenticate extends FunctionNode
{
    private Node $email;

    private Node $password;

    /**
     * @inheritDoc
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf('STAFFER_AUTHENTICATE(%s, %s)',
            $this->email->dispatch($sqlWalker),
            $this->password->dispatch($sqlWalker));
    }

    /**
     * @inheritDoc
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->email = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->password = $parser->StringPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
