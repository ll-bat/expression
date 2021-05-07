<?php 

abstract class Errorable {
  private const HANDLE_SOFT = 1;
  private const HANDLE_HARD = 2;
  private $mode = self::HANDLE_HARD;
  
  public function error($msg) {
    echo PHP_EOL;
    echo "-------- ERROR: start ---------" . PHP_EOL;
    echo PHP_EOL;
    if ($this->isSoftMode()) {
      try {
        $this->throwError($msg);
      } catch(Exception $e) {
        echo $e->getMessage() . PHP_EOL;
      }
    } else {
      $this->throwError($msg);
    }

    echo PHP_EOL;
    echo "-------- ERROR: end -----------" . PHP_EOL;

    exit(0);
  }

  private function isSoftMode() {
    return $this->mode === self::HANDLE_SOFT;
  }

  public function setSoftErrorHandler() {
    $this->mode = self::HANDLE_SOFT;
  }

  public function setHardErrorHandler() {
    $this->mode = self::HANDLE_HARD;
  }

  protected abstract function throwError($msg);

}