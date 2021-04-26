<?php 



class StringHelper {
  public static function removeWhitespaces($e) {
    return preg_replace('/\s+/', '', $e);
  }
}