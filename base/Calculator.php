<?php 

class Calculator {
  protected $operators = [];
  private $_operatorToCallbackMapper = [];

  protected function init() {
    $this->register('+', 1, '_add');
    $this->register('-', 1, '_subtract');
    $this->register('*', 2, '_multiply');
    $this->register('/', 2, '_divide');
    $this->register('^', 3, '_power');
    $this->register('%', 4, '_reminder');
  }

  private function register($operator, $privilege, $callback) {
    $this->operators[$operator] = $privilege;
    $this->_operatorToCallbackMapper[$operator] = $callback;
  }

  private static function _add($a, $b) {
    return $a + $b;
  }

  private static function _subtract($a, $b) {
    return $a - $b;
  }

  private static function _multiply($a, $b) {
    return $a * $b;
  }

  private static function _divide($a, $b) {
    if ($b == 0) {
      throw new Exception('Division by zero: ' . ($a . ' / ' . $b));
    }

    return $a / $b;
  }

  private static function _power($a, $b) {
    return pow($a, $b);
  }

  private static function _reminder($a, $b) {
    if ($b == 0) {
      throw new Exception('Reminder By Zero Exception: ' . $a . ' % ' . $b);
    }
    return $a % $b;
  }

  private function getCalculator($operationType) {
    if ($this->isOperator($operationType)) {
      $func = $this->_operatorToCallbackMapper[$operationType];

      return function ($a, $b) use($func) {
        return self::$func($a, $b);
      };
    }

    return null;
  }

  protected function doOperation($operationType, $a, $b) {
    $calculatorFunction = $this->getCalculator($operationType);

    if (!$calculatorFunction) {
      throw new Exception('Unsupported operator: ' . $operationType);
    }
    
    return $calculatorFunction($a, $b);
  }

  protected function getLevels() {
    $operators = $this->operators;

    asort($operators);
    $operators = array_reverse($operators);

    $levels = [];
    $cur = [];
    $max = max($operators);

    foreach ($operators as $operator => $privilege) {
      if ($privilege == $max) {
        $cur[] = $operator;
      } else {
        $levels[] = $cur;
        $cur = [$operator];
        $max = $privilege;
      }
    }

    $levels[] = $cur;

    return $levels;
  }

}