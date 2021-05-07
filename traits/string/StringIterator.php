<?php 

trait StringIterator {
  private $target;
  private $length;
  private $cur = 0;

  public function setStringIterator(string $target) {
    $this->target = $target;
    $this->length = strlen($target);
  }

  public function nextLetter() {
    if ($this->cur === 0 && !$this->target) {
      $this->error('Please provide the string to iterate, first');
    }

    if ($this->cur >= $this->length) {
      return null;
    }

    return $this->target[$this->cur++];
  }

  public function getPrevLetter() {
    if ($this->cur === 0) {
      return null;
    }

    return $this->target[$this->cur - 2];
  }

  public function getNextLetter() {
    if ($this->cur >= $this->length) {
      return null;
    }

    return $this->target[$this->cur];
  }

  public function error($msg) {
    return parent::error($msg . ', at position: ' . $this->cur . ', character: ' . $this->target[$this->cur - 1] .', input: ' . $this->target);
  }

}