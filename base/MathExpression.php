<?php 

class MathExpression extends Expression {

  public function __construct() {
    $this->init();
  }

  private function removeWhitespaces($e) {
    return preg_replace('/\s+/', '', $e);
  }

  public function isValid($expression) {
    $isNumber = function ($letter) {
      return $this->isNumber($letter);
    };

    $isOperator = function ($letter) {
      return $this->isOperator($letter);
    };

    $isParentheses = function ($letter) {
      return $this->isParentheses($letter);
    };

    // Convert string into array 
    $expression = str_split($expression);

    // Each character in expression should be number, operator, parentheses or dot 
    foreach ($expression as $i => $letter) {
      if (!($isNumber($letter) || $isOperator($letter) || $isParentheses($letter))) {
        // 1.25 is allowed
        if ($letter === '.' && isset($expression[$i - 1]) && isset($expression[$i + 1])
           && $isNumber($expression[$i - 1]) && $isNumber($expression[$i + 1])
           ) {
            continue;
        }

        return false;
      }
    }

    // There must not be two consecutive operators 
    for ($i = 1; $i < count($expression); $i++) {
      if ($isOperator($expression[$i]) && $isOperator($expression[$i - 1])) {
        return false;
      }
    }

    // There must not be such substrings: '5(', '0(', 'x(', ')5', ')0', ')x'
    for ($i = 1; $i < count($expression); $i++) {
      if ($expression[$i] === '(' && $isNumber($expression[$i - 1])) {
        return false;
      }

      if ($isNumber($expression[$i]) && $expression[$i - 1] === ')') {
        return false;
      }
    }

    // Check if parentheses are placed correctly
    // First we take just parentheses
    // And then iterate and check their order 
    $parentheses = [];
    foreach ($expression as $letter) {
      if ($isParentheses($letter)) {
        $parentheses[] = $letter;
      }
    }

    // Let's assign 1 to '(' and -1 to ')' 
    // And calculate the product of the [[ $parentheses ]]
    // So, if we have: '( ( ) ) )' , then the product is:  1 + 1 - 1 - 1 - 1 = -1
    // If the parentheses are correct, then the final result will be 0
    // And, there will not be the product less than zero, when summing up the 
    // the numbers at any index
    $result = 0;
    foreach ($parentheses as $letter) {
      if ($letter === '(') {
        $result++;
      } else {
        $result--;
      }

      if ($result < 0) {
        return false;
      }
    }

    if ($result !== 0) {
      return false;
    }

    // First character should not be '+' and last character should not be '-'
    if (!count($expression)) {
      return false;
    }

    if ($expression[0] === '+' || end($expression) === '-') {
      return false;
    }

    // Otherwise The [[ $expression ]] is mathematically correct
    return true;
  }

  public function evaluate(string $expression) {
     $expression = $this->removeWhitespaces($expression);

     if (!$this->isValid($expression)) {
       echo 'Non-valid expression: ' . $expression . PHP_EOL;
       return null;
     }

     $result = $this->findResult($expression);
     return round($result, 7);
  }

  public function runTests() {
    $expressions = [
      '(1 + (2 + 2 * 2 + 2)) * (-3)',
      '(9 / 4) + 1',
      '1.25 + 1'
    ];

    // 

    foreach ($expressions as $expression) {
      var_dump(
        $expression . ' = ' . $this->evaluate($expression)
      );
    }
  }

}