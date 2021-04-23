<?php

require_once 'base/Calculator.php';
require_once 'base/Format.php';
require_once 'base/Expression.php';
require_once 'base/MathExpression.php';

function calc(string $expression) {
  return (new MathExpression)->evaluate($expression);
}

function calcAndPrint(string $expression) {
  echo $expression . ' = ' . calc($expression) . PHP_EOL;
}

calcAndPrint('(1 + (1 / (0.1 + 0.2))) * 3 / 13');
calcAndPrint('1/1/588.01');
calcAndPrint('90/(10-1)');
calcAndPrint('1 / 2 ^ (1 + 1) % 2');