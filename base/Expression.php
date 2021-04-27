<?php 

require_once 'traits/math/Format.php';

class Expression extends Calculator {
  use Format;

  protected function findResult($e) {
    return $this->findWithParenthesesIncluded($e);
  }

  private function getMostNestedParentheses($expression) {
    $firstClosingParenthesesIndex = strpos($expression, ')');
    $lastOpeningParenthesesBeforeFirstClosingParentheses = null;

    for ($i = $firstClosingParenthesesIndex; $i >= 0; $i--) {
      if ($expression[$i] === '(') {
        $lastOpeningParenthesesBeforeFirstClosingParentheses = $i;
        break;
      }
    }

    return [$lastOpeningParenthesesBeforeFirstClosingParentheses, $firstClosingParenthesesIndex];
  }

  private function findWithParenthesesIncluded($e) {
    $result = $e;

    // Count pairs of parenteses in [[ $e ]]
    $countOfParentheses = 0;
    for ($i = 0; $i < strlen($e); $i++) {
      if (in_array($e[$i], ['(', ')'])) {
        $countOfParentheses++;
      }
    };

    $countOfParentheses /= 2;

    // While there is a pair of parenteses in [[ $e ]]
    // Extract the smaller expression from parentheses
    // Calculate it 
    // And then replace extracted expression with calculated result in [[ $e ]]
    while ($countOfParentheses--) {
      [$a, $b] = $this->getMostNestedParentheses($result);
      $subExpression = substr($result, $a, $b - $a + 1);

      $subExpressionResult = $this->findWithoutParentheses($subExpression);
      $result = str_replace($subExpression, $subExpressionResult, $result);
    }

    return $this->findWithoutParentheses($result);
  }

  private function getFilteredSubExpression($e) {
    // ()
    if ($e === "()")  {
      $this->error('Non-valid expression');
    }

    // (1 + 1) -> 1 + 1
    if ($e[0] === '(') {
      $e = substr($e, 1, strlen($e) - 2);
    }

    if ($e[0] === '+' || $e[-1] === '-') {
      $this->error('Non-valid expression: ' . $e);
    }

    if ($e[0] == '-') {
      // -5 = 0 - 5 ( Just convert it to valid mathematical expression for simplicity )
      $e = '0' . $e;
    }

    return $e;
  }

  /**
  * '1 + 1 * 2'
  *  = 
  * $numbers    = [1, 1, 2]
  * $operations = ['+', '*']
  *
  * returns [$numbers, $operations]
  */
  private function divideExpressionIntoNumbersAndOperations($e) {
    $numbers = [];
    $operations = [];

    $cur = '';

    for ($i = 0; $i < strlen($e); $i++) {
      $letter = $e[$i];

      if ($this->isOperator($letter)) {
        // 9 * (5 - 7) = 9 * -2
        if ($letter === '-' && $i > 0 && $this->isOperator($e[$i - 1])) {
          $cur = '-';
          continue;
        }

        if (substr_count($cur, '.') > 1) {
          $this->error('Invalid format: ' . $cur);
        }

        if ($cur === '') {
          $this->error('Error in validation, expression: ' . $e);
        }

        $cur = (float) $cur;
        $numbers[] = $cur;
        $operations[] = $letter;
        $cur = '';

      } else {
        $cur .= $letter;
      }
    }

    if (substr_count($cur, '.') > 1) {
      $this->error('Invalid format: ' . $cur);
    }

    if ($cur === '') {
      $this->error('Error in validation, expression: ' . $e);
    }

    $cur = (float) $cur;
    $numbers[] = $cur;

    return [$numbers, $operations];
  }


  private function findWithoutParentheses($e) {
    
    $e = $this->getFilteredSubExpression($e);    

    [$numbers, $operations] = $this->divideExpressionIntoNumbersAndOperations($e);

    foreach ($this->getOperationLevels() as $operators) {
      foreach ($operations as $i => $operator) {

        if (!in_array($operator, $operators)) {
          continue;
        }

        [$a, $b] = [$numbers[$i], $numbers[$i + 1]];

        $result = $this->doOperation($operator, $a, $b);

        $numbers[$i] = null;
        $numbers[$i + 1] = $result;
        $operations[$i] = null;
      }

      $numbers = self::filterNulls($numbers);
      $operations = self::filterNulls($operations);
    }

    $result = $numbers[0];

    // var_dump($result);
    
    return $result;
  }

}