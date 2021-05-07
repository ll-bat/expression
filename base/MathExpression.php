<?php 

require_once 'base/Calculator.php';
// require_once 'base/modules/v1/Logic.php';
require_once 'base/modules/v2/Logic.php';
require_once 'helpers/StringHelper.php';
require_once 'traits/validators/ExpressionValidator.php';


class MathExpression extends Logic {

  use ExpressionValidator;

  public function __construct() {
    $this->init();
  }

  private function evaluate(string $expression, $roundAt = 7) {
     $expression = StringHelper::removeWhitespaces($expression);

     if (!$this->passesBasicValidations($expression)) {
       $this->error('Non-valid expression: ' . $expression);
       return null;
     }

     $result = $this->findResult($expression);
     return round($result, $roundAt);
  }

  public static function calculate(string $expression) {
     $model = new self();
     $model->setSoftErrorHandler();
     return $model->evaluate($expression);
  }


}