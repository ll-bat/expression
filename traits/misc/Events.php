<?php

trait Events {
  private $_events = [];

  protected function registerHandler($key, $handler) {
    if (isset($this->_events[$key])) {
      // Notify user
    }

    $this->_events[$key] = $handler;
  }

  protected function hasHandler($key) {
    return isset($this->_events[$key]);
  }
  
  protected function triggerHandler($key, ...$params) {
    if ($this->hasHandler($key)) {
      return call_user_func($this->_events[$key], ...$params);
    }

    $this->error('Such event: '.  $key . ' does not exist');
  }
}