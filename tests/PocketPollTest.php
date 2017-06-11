<?php

use \PWelty\PocketPoll\Pocket;

class PocketTest extends PHPUnit_Framework_TestCase {

  public function setUp() {
    $env_file_path = __DIR__ . '/../';
    if (file_exists($env_file_path . '.env')) {
        $dotenv = new Dotenv\Dotenv($env_file_path);
        $dotenv->load();
    }
  }

}

?>
