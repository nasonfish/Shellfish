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
require 'Predis/Autoloader.php';
Predis\Autoloader::register();
$redis = new Predis\Client();
$pass = trim(file_get_contents_d('../redispass.txt'));
$auth = new Predis\Command\ConnectionAuth();
$auth->setRawArguments(array($pass));
$redis->executeCommand($auth);

$passwords = array(
    'nasonfish' => 'fish',
    'puffrfish' => 'nene' // Add passwords like this
);

function auth(){
    if(get('admin:auth')){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Shellfish.io - Tutorial Manager\"");
            header("HTTP/1.0 401 Unauthorized");
            echo '401 Unauthorized - No username/password supplied. Sorry.';
            exit;
        } else {
            if(!isset($passwords[$_SERVER['PHP_AUTH_USER']]) || $_SERVER['PHP_AUTH_PW'] != $passwords[$_SERVER['PHP_AUTH_USER']]){
                header("WWW-Authenticate: Basic realm=\"Shellfish.io - Tutorial Manager\"");
                header("HTTP/1.0 401 Unauthorized");
                echo "401 Unauthorized - Incorrect username/password. Sorry.";
                exit;
            }
        }
    }
}
