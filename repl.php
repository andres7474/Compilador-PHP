<?php

require_once 'Lexer.php'; 
require_once 'Parser.php';  
require_once 'Evaluator.php'; 

function startRepl() {
    echo "Welcome to Isaac Cancele's Monkey REPL\n";
    echo "Type 'exit' to exit\n";

    while (true) {
        try {
            echo ">> ";
            $source = trim(fgets(STDIN));
            if (strtolower($source) === 'exit') {
                break;
            }

            $lexer = new Lexer($source);
            $parser = new Parser($lexer);
            $program = $parser->parseProgram();

            if (!empty($parser->getErrors())) {
                echo "Parser errors:\n";
                foreach ($parser->getErrors() as $err) {
                    echo "  ✖ $err\n";
                }
                continue; 
            }


            $result = evalNode($program);
            if ($result !== null) {
                echo $result->inspect() . "\n";
            }

        } catch (Exception $e) {
            echo "Runtime Error: " . $e->getMessage() . "\n";
        }
    }
}

startRepl();

?>
