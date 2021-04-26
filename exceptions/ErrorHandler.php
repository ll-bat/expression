<?php 

require_once 'exceptions/Errorable.php';

class ErrorHandler extends Errorable {
  protected function throwError($msg) {
    throw new Exception($msg);
  }
}