<?php
global $_CONFIG;
$_CONFIG = array();

$_CONFIG['index:main-header'] = 'The world of linux is beneath your fingertips';
$_CONFIG['index:sub-header'] = 'Shellfish is an easy-to-use system for publishing tutorials and other helpful articles';
$_CONFIG['index:all-button'] = 'List all Tutorials';
$_CONFIG['index:category-button'] = 'View by Category';

$_CONFIG['backend:domain'] = "Shellfish.io";

$_CONFIG['main:title'] = 'Shellfish - Tutorials and Beyond!'; // TODO?
$_CONFIG['main:bar-title'] = 'Shellfish<span style="font-size: 25px;">.io</span>';
$_CONFIG['main:bar-search'] = 'Search for tutorials!';

$_CONFIG['backend:ssl:self-signed'] = true; // This will append --no-check-certificate to the wget command for "Do it for me!".

$_CONFIG['admin:auth'] = true;

global $redis;
$this->redis = new Predis\Client();
$pass = trim(file_get_contents_d('../redispass.txt'));
$auth = new Predis\Command\ConnectionAuth();
$auth->setRawArguments(array($pass));
$this->redis->executeCommand($auth);
