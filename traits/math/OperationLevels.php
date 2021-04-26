<?php 


trait OperationLevels {
  protected function getOperationLevels() {
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