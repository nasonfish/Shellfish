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
        $results = array();
        foreach($tags as $tag){
            $results[$tag] = array();
            $command = new Predis\Command\SetIsMember();
            $command->setRawArguments(array('tags', $tag));
            if($this->redis->executeCommand($command)){
                return array(); // "That tag doesn't really exist. Sorry"
            }
            foreach($pages as $pageid){
                $cmd = new Predis\Command\SetIsMember();
                $cmd->setRawArguments(array('tag:' . $tag, $pageid));
                if($this->redis->executeCommand($cmd)){
                    $results[$tag][] = $pageid;
                }
            }
        }
        $return = false;
        foreach($results as $pages){
            if($return === false){
                $return = $pages;
            } else {
                $return = array_intersect($return, $pages);
            }
        }
        return $return === false ? array() : ($limit < 0 ? $return : array_slice($return, $limit * $pagination, $limit));
    }

    public function create($title = "New Tutorial", $description = "Tutorial description", $text = "Tutorial", $download = false, $tags = array()){

        // First, let's just initialize the database. This is pretty simple, but you can comment it out after there are things in the database.
        // I'll do that later
        $cmd = new Predis\Command\KeyExists();
        $cmd->setRawArguments(array('next_id'));
        if(!$this->redis->executeCommand($cmd)){
            $cmd = new Predis\Command\StringSet();
            $cmd->setRawArguments(array('next_id', 0)); // There's no current page, so we start at 0.
            $this->redis->executeCommand($cmd);
            $id = 0;
        } else {
            $cmd = new Predis\Command\StringGet();
            $cmd->setRawArguments(array('next_id')); // Get what the id should be
            $id = $this->redis->executeCommand($cmd);

            $cmd = new Predis\Command\StringIncrement(); // Auto increment
            $cmd->setRawArguments(array('next_id'));
            $this->redis->executeCommand($cmd); // For next time we add something.
        }
        // String data of the tutorial
        $cmd = new Predis\Command\StringSet();
        $cmd->setRawArguments(array('page:' . $id . ':title', $title));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('page:' . $id . ':description', $description));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('page:' . $id . ':download', $download)); // This can be FALSE/0.
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('page:' . $id . ':text', $text));
        // Tags of the page
        foreach($tags as $tag){
            $cmd = new Predis\Command\SetAdd();
            $cmd->setRawArguments(array('tags', $tag)); // We can use this because if it already exists, it is not added, it returns 0.
            $this->redis->executeCommand($cmd);
            $cmd->setRawArguments(array('tag:' . $tag, $id)); // Add the id to the tag
            $this->redis->executeCommand($cmd);
        }
        return $id;
    }

        /*
         * Okay, so here's our schema.
         * "tags" SET(tagname, othertag, blah)
         * "tag:<tagname>" SET(1, 2, 3, 4, ids_of_pages)
         *
         * "pages" SET(1, 2, 3, 4, ids_of_all_the_pages)
         * "page:<pageid>:(title|description|download|text)" string(the specified thing in a string.)
         *
         * "next_id" string(id of the next page we will add)
         */
}