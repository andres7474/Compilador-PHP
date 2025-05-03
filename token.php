<?php


class TokenType {
    const ASSIGN = 'ASSIGN';
    const BANG = 'BANG';
    const COMMA = 'COMMA';
    const EOF = 'EOF';
    const EQ = 'EQ';
    const IF = 'IF';
    const ELSE = 'ELSE';
    const NOT_EQ = 'NOT_EQ';
    const FOR = 'FOR';
    const FUNCTION = 'FUNCTION';
    const IDENT = 'IDENT';
    const ILLEGAL = 'ILLEGAL';
    const INT = 'INT';
    const LBRACE = 'LBRACE';
    const LET = 'LET';
    const LPAREN = 'LPAREN';
    const PLUS = 'PLUS';
    const MINUS = 'MINUS';
    const ASTERISK = 'ASTERISK';
    const SLASH = 'SLASH';
    const LT = 'LT';
    const GT = 'GT';
    const LE = 'LE';
    const GE = 'GE';
    const RBRACE = 'RBRACE';
    const RPAREN = 'RPAREN';
    const SEMICOLON = 'SEMICOLON';
    const WHILE = 'WHILE';
}

class Token {
    public $tokenType;
    public $literal;

    public function __construct($tokenType, $literal) {
        $this->tokenType = $tokenType;
        $this->literal = $literal;
    }

    public function __toString() {
        return "Token({$this->tokenType}, {$this->literal})";
    }
}

function lookupTokenType($literal) {
    $keywords = [
        'function' => TokenType::FUNCTION,
        'let' => TokenType::LET,
        'if' => TokenType::IF,
        'else' => TokenType::ELSE,
        'for' => TokenType::FOR,
        'while' => TokenType::WHILE
    ];

    return isset($keywords[$literal]) ? $keywords[$literal] : TokenType::IDENT;
}

?>
