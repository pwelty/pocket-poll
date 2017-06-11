<?php

require("vendor/autoload.php");

use \PWelty\PocketPoll\Pocket;

class PocketTest extends \PHPUnit\Framework\TestCase {

  public function setUp() {
    $env_file_path = __DIR__ . '/../';
    if (file_exists($env_file_path . '.env')) {
        $dotenv = new Dotenv\Dotenv($env_file_path);
        $dotenv->load();
    }
  }

  public function testRetrieve() {
    $pocket_consumer_key = getenv('POCKET_CONSUMER_KEY');
    $pocket_access_token = getenv('POCKET_ACCESS_TOKEN');
    $simulate = true;
    $pocket = new Pocket($pocket_consumer_key,$pocket_access_token,$simulate);
    $result = $pocket->getPosts('sg-general-posted','1','oldest');
    $list = $result->list;
    $first_result = reset($list);
    $this->assertEquals('Global Tech Issue 2016', $first_result->resolved_title);
    // echo $first_result->resolved_title; //Global Tech Issue 2016
  }

  public function testHasTag() {
    $pocket_consumer_key = getenv('POCKET_CONSUMER_KEY');
    $pocket_access_token = getenv('POCKET_ACCESS_TOKEN');
    $simulate = false;
    $pocket = new Pocket($pocket_consumer_key,$pocket_access_token,$simulate);
    // Get a post
    $result = $pocket->getPosts('sg-general-posted','1','oldest');
    $id = reset($result->list)->item_id;

    // Add a tag
    $result = $pocket->tagPost($id,'test-tag');

    // Check it
    $result = $pocket->getPosts('sg-general-posted','1','oldest','complete');
    $tagsObj = reset($result->list)->tags;
    $tags = array();
    foreach ($tagsObj as $key=>$value) {
      $tags[] = $key;
    }
    $this->assertContains( 'test-tag' , $tags );
  }

  public function testHasntTag() {
    $pocket_consumer_key = getenv('POCKET_CONSUMER_KEY');
    $pocket_access_token = getenv('POCKET_ACCESS_TOKEN');
    $simulate = false;
    $pocket = new Pocket($pocket_consumer_key,$pocket_access_token,$simulate);
    $result = $pocket->getPosts('sg-general-posted','1','oldest');
    $id = reset($result->list)->item_id;

    // Remove it
    $result = $pocket->untagPost($id,'test-tag');

    // Check it again
    $result = $pocket->getPosts('sg-general-posted','1','oldest','complete');
    $tagsObj = reset($result->list)->tags;
    $tags = array();
    foreach ($tagsObj as $key=>$value) {
      $tags[] = $key;
    }
    $this->assertNotContains( 'test-tag' , $tags );


  }

}

?>
