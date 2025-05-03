<?php

class Lexer {
    private $source;
    private $character = '';
    private $readPosition = 0;
    private $position = 0;

    public function __construct($source) {
        $this->source = $source;
        $this->readChar();
    }

    public function nextToken() {
        $this->skipWhitespace();

        if ($this->character === '=') {
            if ($this->_peekCharacter() === '=') {
                $this->readChar();
                return new Token(TokenType::EQ, "==");
            } else {
                return new Token(TokenType::ASSIGN, $this->character);
            }
        } elseif ($this->character === '!') {
            if ($this->_peekCharacter() === '=') {
                $this->readChar();
                return new Token(TokenType::NOT_EQ, "!=");
            } else {
                return new Token(TokenType::BANG, "!");
            }
        } elseif ($this->character === '+') {
            return new Token(TokenType::PLUS, $this->character);
        } elseif ($this->character === '-') {
            return new Token(TokenType::MINUS, $this->character);
        } elseif ($this->character === '*') {
            return new Token(TokenType::ASTERISK, $this->character);
        } elseif ($this->character === '/') {
            return new Token(TokenType::SLASH, $this->character);
        } elseif ($this->character === '<') {
            if ($this->_peekCharacter() === '=') {
                $this->readChar();
                return new Token(TokenType::LE, "<=");
            } else {
                return new Token(TokenType::LT, $this->character);
            }
        } elseif ($this->character === '>') {
            if ($this->_peekCharacter() === '=') {
                $this->readChar();
                return new Token(TokenType::GE, ">=");
            } else {
                return new Token(TokenType::GT, $this->character);
            }
        } elseif ($this->character === '(') {
            return new Token(TokenType::LPAREN, $this->character);
        } elseif ($this->character === ')') {
            return new Token(TokenType::RPAREN, $this->character);
        } elseif ($this->character === '{') {
            return new Token(TokenType::LBRACE, $this->character);
        } elseif ($this->character === '}') {
            return new Token(TokenType::RBRACE, $this->character);
        } elseif ($this->character === ',') {
            return new Token(TokenType::COMMA, $this->character);
        } elseif ($this->character === ';') {
            return new Token(TokenType::SEMICOLON, $this->character);
        } elseif ($this->_isNumber($this->character)) {
            $number = $this->_readNumber();
            return new Token(TokenType::INT, $number);
        } elseif ($this->_isLetter($this->character)) {
            $literal = $this->_readLiteral();
            $tokenType = lookupTokenType($literal);
            return new Token($tokenType, $literal);
        } elseif ($this->character === '') {
            return new Token(TokenType::EOF, "");
        } else {
            return new Token(TokenType::ILLEGAL, $this->character);
        }

        $this->readChar();
    }

    private function skipWhitespace() {
        while (preg_match('/^\s$/', $this->character)) {
            $this->readChar();
        }
    }

    private function _isNumber($character) {
        return preg_match('/^\d$/', $character) === 1;
    }

    private function _isLetter($character) {
        return preg_match('/^[a-zA-Z]$/', $character) === 1;
    }

    private function _readNumber() {
        $initialPosition = $this->position;
        while ($this->_isNumber($this->character)) {
            $this->readChar();
        }
        return substr($this->source, $initialPosition, $this->position - $initialPosition);
    }

    private function _readLiteral() {
        $initialPosition = $this->position;
        while ($this->_isLetter($this->character) || $this->_isNumber($this->character)) {
            $this->readChar();
        }
        return substr($this->source, $initialPosition, $this->position - $initialPosition);
    }

    private function readChar() {
        if ($this->readPosition >= strlen($this->source)) {
            $this->character = '';
        } else {
            $this->character = $this->source[$this->readPosition];
        }

        $this->position = $this->readPosition;
        $this->readPosition++;
    }

    private function _peekCharacter() {
        if ($this->readPosition >= strlen($this->source)) {
            return '';
        }
        return $this->source[$this->readPosition];
    }
}

?>
