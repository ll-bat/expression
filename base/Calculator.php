<?php 

require_once 'root/Application.php';
require_once 'traits/math/MathOperations.php';
require_once 'traits/math/OperationLevels.php';

class Calculator extends Application {
  use MathOperations;
  use OperationLevels;

  protected $operators = [];

  protected function init() {
    $this->addOperator('+', 1, '_add');
    $this->addOperator('-', 1, '_subtract');
    $this->addOperator('*', 2, '_multiply');
    $this->addOperator('/', 2, '_divide');
    $this->addOperator('^', 3, '_power');
    $this->addOperator('%', 4, '_reminder');
    $this->addOperator('&', 3, '_and');
  }

  private function addOperator($type, $weight, $callback) {
    $this->operators[$type] = $weight;
    $this->registerHandler($type, [$this, $callback]);
  }

  protected function doOperation($operationType, $a, $b) {
      return $this->triggerHandler($operationType, $a, $b);
  }
}