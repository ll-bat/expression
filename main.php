<?php

require_once 'base/MathExpression.php';

function calc(string $expression) {
  return MathExpression::calculate($expression);
}

function calcAndPrint(string $expression) {
  echo $expression . ' = ' . calc($expression) . PHP_EOL;
}

calcAndPrint('(1 + (1 / (0.1 + 0.2))) * 3 / 13');
calcAndPrint('1/1/588.01');
calcAndPrint('90/(10-1)');
calcAndPrint('1 / 2 ^ (1 + 1) % 2');
calcAndPrint('1 / a ^ (1 + 1) % 2');