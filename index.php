<?php
// include
//
require_once 'lib/config.controller.php';
require_once 'MQTTBridgeController.php';

if (!file_exists('config.php')) die("please create config.php in your web folders root at first\nYou might want to copy the config.sample.php as a start.");

require_once 'config.php';

// load config
Config::set('ALL',$config);

// start controller

$controller = new MQTTBridgeController();
