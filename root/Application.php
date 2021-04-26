<?php 

require_once 'exceptions/ErrorHandler.php';
require_once 'traits/misc/Events.php';

class Application extends ErrorHandler  {
  use Events;
  

}