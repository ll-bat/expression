<?php 



trait MathOperations {

  protected static function _add($a, $b) {
    return $a + $b;
  }

  protected static function _subtract($a, $b) {
    return $a - $b;
  }

  protected static function _multiply($a, $b) {
    return $a * $b;
  }

  protected static function _divide($a, $b) {
    if ($b == 0) {
      $this->error('Division by zero: ' . ($a . ' / ' . $b));
    }

    return $a / $b;
  }

  protected static function _power($a, $b) {
    return pow($a, $b);
  }

  protected static function _reminder($a, $b) {
    if ($b == 0) {
      $this->error('Reminder By Zero Exception: ' . $a . ' % ' . $b);
    }
    return $a % $b;
  }
}