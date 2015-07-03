<?php
/**
 * Example code to call Rosette API to get linked (against Wikipedia) entities from a piece of text
 **/

require_once(dirname(__FILE__) . "/../vendor/autoload.php"); // assuming composer.json is properly configured with Rosette API
use rosette\api\Api;
use rosette\api\DocumentParameters;
use rosette\api\RosetteException;

$options = getopt(null, array("key:", "url::"));
if (!isset($options["key"])) {
    echo "Usage: php " . __FILE__ . " --key <api_key> --url=<alternate_url>\n";
    exit();
}

$api = isset($options["url"]) ? new Api($options["key"], $options["url"]) : new Api($options["key"]);
$api->setVersionChecked(true);
$params = new DocumentParameters();
$params->params["content"] = <<<EOF
President Obama urges the Congress and Speaker Boehner to pass the $50 billion spending bill
based on Christian faith by July 1st or Washington will become totally dysfunctional,
a terrible outcome for American people.
EOF;

try {
    $result = $api->entities($params, true);
    var_dump($result);
} catch (RosetteException $e) {
    error_log($e);
}
