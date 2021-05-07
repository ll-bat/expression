<?php 

require_once 'traits/math/Format.php';
require_once 'traits/string/StringIterator.php';

class Logic extends Calculator {
  use Format;
  use StringIterator;

  protected function findResult($e) {

    $this->setStringIterator($e);

    return $this->evaluate();

  }

  private function evaluate() {

    [$numbers, $operations] = $this->divideExpressionIntoNumbersAndOperations();

    return $this->combine($numbers, $operations);

  }


  /**
  * '1 + 1 * 2'
  *  = 
  * $numbers    = [1, 1, 2]
  * $operations = ['+', '*']
  *
  * returns [$numbers, $operations]
  */
  private function divideExpressionIntoNumbersAndOperations() {
    $numbers = [];
    $operations = [];

    $cur = '';

    while ( ($letter = $this->nextLetter()) != null ) {
      if ($this->isNumber($letter) || $letter === '.') {

        $cur .= $letter;

      } else {

        if ($this->isOperator($letter)) {
          if ($this->isOperator($this->getPrevLetter())) {
            $this->error('Invalid Expression; prev letter is operator');
          }

          if ($cur === '') {
            if ($letter === '-') {
              $cur = '-';
              continue;
            } else {
              $this->error('Invalid Expression; double operators');
            }
          }

          if (substr_count($cur, '.') > 1) {
            $this->error('Invalid number: ' . $cur);
          }

          if ($cur === '-') { 
            $this->error('Invalid Expression: only "-" sign');
          }

          $cur = (float) $cur;
          $numbers[] = $cur;
          $operations[] = $letter;
          $cur = '';

        }

        else if ($this->isParentheses($letter)) {

          if ($this->isOpeningParentheses($letter)) {

            $val = $this->evaluate();

            if ($cur === '-') {
              $val *= -1;
            }

            $cur = $val;

          } else {

            break;

          }

        }

        else {
          $this->error('Unsupported character: ' . $letter);
        }

      } 

    }  



    if ($cur === '-' || $cur === '' || substr_count($cur, '.') > 1) {
      $this->error('Invalid Expression');
    }

    $cur = (float) $cur;
    $numbers[] = $cur;

    return [$numbers, $operations];
  }


  private function combine($numbers, $operations) {

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