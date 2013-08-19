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
 * Class Page
 * @package Tutorials.pufferfi.sh
 */

class Page{

    private $id;
    private $redis;

    /**
     * Create a new page! WE'RE JUST AN INTEGER!
     */
    public function __construct($id = false, Tutorials $predis){
        if(!$predis->exists($id)){
            throw new PredisPageDoesNotExistException($id, "Predis Page Construct");
        }
        $this->id = $id;
        $this->redis = $predis->getPredis();
    }

    public function getTags(){
        $return = array();
        $cmd = new Predis\Command\SetMembers();
        $cmd->setRawArguments(array('tags'));
        $result = $this->redis->executeCommand($cmd);
        foreach($result as $tag){
            $checkCommand = new Predis\Command\SetIsMember();
            $checkCommand->setRawArguments(array('tag:' . $tag, $this->id));
            if($this->redis->executeCommand($checkCommand)){
                $return[] = $tag;
            }
        }
        return $return;
    }

    public function getText(){
        $cmd = new Predis\Command\StringGet();
        $cmd->setRawArguments(array('page:' . $this->id . ':text'));
        return $this->redis->executeCommand($cmd);
    }

    public function getDescription(){
        $cmd = new Predis\Command\StringGet();
        $cmd->setRawArguments(array('page:' . $this->id . ':description'));
        return $this->redis->executeCommand($cmd);
    }

    public function getTitle(){
        $cmd = new Predis\Command\StringGet();
        $cmd->setRawArguments(array('page:' . $this->id . ':title'));
        return $this->redis->executeCommand($cmd);
    }

    public function getDownload(){
        $cmd = new Predis\Command\KeyExists();
        $cmd->setRawArguments(array('page:' . $this->id . ':download'));
        if(!$this->redis->executeCommand($cmd)){
            return false;
        }
        $cmd = new Predis\Command\StringGet();
        $cmd->setRawArguments(array('page:' . $this->id . ':download'));
        return $this->redis->executeCommand($cmd);
    }

    public function getUsername(){
        $cmd = new Predis\Command\StringGet();
        $cmd->setRawArguments(array('page:' . $this->id . ':username'));
        return $this->redis->executeCommand($cmd);
    }

    public function getIP(){
        // We probably won't use this, but it's good to have it, just in case bad things happen.
        $cmd = new Predis\Command\StringGet();
        $cmd->setRawArguments(array('page:' . $this->id . ':ip'));
        return $this->redis->executeCommand($cmd);
    }

    public function getId(){
        return $this->id;
    }
}