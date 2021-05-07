<?php 



trait Format {
  private $_numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
  private $_parentheses = ['(', ')'];

  private static function _in($l, $arr) { 
    return in_array($l, $arr);
  }

  protected function isNumber($letter) {
    return self::_in($letter, $this->getNumbers());
  }

  protected function isOperator($letter) {
    return self::_in($letter, $this->getOperators());
  }

  protected function isParentheses($letter) {
    return self::_in($letter, $this->getParentheses());
  }

  protected function isOpeningParentheses($letter) {
    return $letter === '(';
  }

  protected function isClosingParentheses($letter) {
    return $letter === ')';
  }

  protected function getNumbers() {
    return $this->_numbers;
  }

  protected function getOperators() {
    return array_keys($this->operators);
  }

  protected function getParentheses() {
    return $this->_parentheses;
  }

  protected static function isValidCharacter($letter) {
    return $this->isNumber($letter) || $this->isOperator($letter)
           || $this->isParentheses($letter);
  }

  protected static function filterNulls(array $array) {
    $result = [];

    foreach ($array as $item) {
      if ($item !== null) {
        $result[] = $item;
      }
    }

    return $result;
  }
}