<?php

declare(strict_types = 1);

namespace Jackin\Tools;

class Cli {
    public function getInput(string $question) {
        echo $question.PHP_EOL;
        $handle = fopen ("php://stdin","r");
        $line = fgets($handle);
        fclose ($handle);

        return trim($line);
    }
}