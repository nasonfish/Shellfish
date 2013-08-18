<?php
/*
    Tutorials, by pufferfi.sh, a site of tutorials for snippets of usage of different software.
    Copyright (C) 2013  nasonfish
    nasonfish <at> gmail [dot] com

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see {http://www.gnu.org/licenses/}.
 */


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