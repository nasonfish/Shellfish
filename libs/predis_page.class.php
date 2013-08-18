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
    private $predis;

    /**
     * Create a new page! WE'RE JUST AN INTEGER!
     */
    public function __construct($id = false, Predis_Interface $predis){
        if(!$predis->exists($id)){
            throw new PredisPageDoesNotExistException($id, "Predis Page Construct");
        }
        $this->id = $id;
        $this->predis = $predis;
    }

    public function getTags(){
        $return = array();
        $cmd = new Predis\Command\SetMembers();
        $cmd->setRawArguments(array('tags'));
        $result = $this->predis->getPredis()->executeCommand($cmd);
        foreach($result as $tag){
            $checkCommand = new Predis\Command\SetIsMember();
            $checkCommand->setRawArguments(array('tag:' . $tag, $this->id));
            if($this->predis->getPredis()->executeCommand($checkCommand)){
                $return[] = $tag;
            }
        }
    }

    public function getText(){
        $cmd = new Predis\Command\StringGet();
        $cmd->setRawArguments(array('page:' . $this->id . ':text'));
        return $this->predis->getPredis()->executeCommand($cmd);
    }

    public function getDescription(){
        $cmd = new Predis\Command\StringGet();
        $cmd->setRawArguments(array('page:' . $this->id . ':description'));
        return $this->predis->getPredis()->executeCommand($cmd);
    }

    public function getTitle(){
        $cmd = new Predis\Command\StringGet();
        $cmd->setRawArguments(array('page:' . $this->id . ':title'));
        return $this->predis->getPredis()->executeCommand($cmd);
    }

    public function getDownload(){
        $cmd = new Predis\Command\KeyExists();
        $cmd->setRawArguments(array('page:' . $this->id . ':download'));
        if(!$this->predis->getPredis()->executeCommand($cmd)){
            return false;
        }
        $cmd = new Predis\Command\StringGet();
        $cmd->setRawArguments(array('page:' . $this->id . ':download'));
        return $this->predis->getPredis()->executeCommand($cmd);
    }
}