<?php

/**
 * Class Predis_Interface
 * @package Tutorials.pufferfi.sh
 */

class Predis_Interface {

    /**
     * The database object, yo~!
     * @var Predis\Client
     */
    private $redis;

    public function __construct(){
        require 'Predis/Autoloader.php';
        Predis\Autoloader::register();
        $this->redis = new Predis\Client();
    }

    public function getPredis(){
        return $this->redis;
    }

    /**
     * Check if a page exists in the redis database
     * @param bool $id The id of the page.
     * @return bool|mixed|\Predis\ResponseObjectInterface
     */
    public function exists($id = false){
        if($id === false){
            return false;
        } else {
            $cmd = new Predis\Command\SetIsMember();
            $cmd->setRawArguments(array("pages", $id));
            return $this->redis->executeCommand($cmd);
        }
    }

    public function getAllPages(){
        $cmd = new Predis\Command\SetMembers();
        $cmd->setRawArguments(array('pages'));
        return $this->redis->executeCommand($cmd);
    }

    public function tagSearch($tags = array(), $limit = 10, $pagination = 1){
        $pages = $this->getAllPages();
        $result = array();
        foreach($tags as $tag){
            $command = new Predis\Command\SetIsMember();
            $command->setRawArguments(array('tags', $tag));
            if($this->redis->executeCommand($command)){
                return array(); // "That tag doesn't really exist. Sorry"
            }
            foreach($pages as $id => $page){
                $cmd = new Predis\Command\
            }
        }
    }
}