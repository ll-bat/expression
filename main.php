<?php

require_once 'base/MathExpression.php';

function calc(string $expression) {
  return MathExpression::calculate($expression);
}

function calcAndPrint(string $expression) {
  echo $expression . ' = ' . calc($expression) . PHP_EOL;
}

calcAndPrint('(1 + (1 / (0.1 + 0.2))) * 3 / 13');  # prints 1
calcAndPrint('1/1/588.01');  # prints 0.017007
calcAndPrint('90/(10-1)');   # prints 10
calcAndPrint('1 / 2 ^ (1 + 1) % 2'); # prints 1
calcAndPrint('1 / a ^ (1 + 1) % 2'); # Throws exception
// calcAndPrint('1 / 1 ^ (1 + (3 / 0) - 1) % 2'); # Throws exception