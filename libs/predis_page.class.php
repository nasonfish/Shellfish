<?php

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