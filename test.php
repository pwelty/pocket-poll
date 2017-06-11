<?php

require("vendor/autoload.php");

use \PWelty\PocketPoll\Pocket;

$env_file_path = __DIR__ . '/';
if (file_exists($env_file_path . '.env')) {
    $dotenv = new Dotenv\Dotenv($env_file_path);
    $dotenv->load();
}
$pocket_consumer_key = getenv('POCKET_CONSUMER_KEY');
$pocket_access_token = getenv('POCKET_ACCESS_TOKEN');
$simulate = true;
$pocket = new Pocket($pocket_consumer_key,$pocket_access_token,$simulate);
$result = $pocket->getPosts('sg-general-posted','1','oldest','complete');
$list = $result->list;
// print_r($list);
$first_result = reset($list);
// $id = reset($list)->id;
// $first_result = $results->$id;
print_r($first_result);
echo $first_result->resolved_title; //Global Tech Issue 2016

$id = reset($result->list)->item_id;
$result = $pocket->tagPost($id,'test-tag');
print_r($result);
exit;

$tagsObj = $first_result->tags;
$tags = array();
foreach ($tagsObj as $key=>$value) {
  $tags[] = $key;
}
print_r($tags);

?>
