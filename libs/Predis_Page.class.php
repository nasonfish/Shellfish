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
    private $tutorials;

    /**
     * Create a new page! WE'RE JUST AN INTEGER!
     */
    public function __construct($id = false, Tutorials $tutorials){
        if(!$tutorials->exists($id)){
            throw new PredisPageDoesNotExistException($id, "Predis Page Construct");
        }
        $this->id = $id;
        $this->redis = $tutorials->getPredis();
        $this->tutorials = $tutorials;
    }

    public function view(){
        $views = $this->getViews();
        $cmd = new Predis\Command\SetAdd();
        $cmd->setRawArguments(array('page:' . $this->id . ':views', $this->tutorials->getPeregrine()->server->getIP('REMOTE_ADDR')));
        if($this->redis->executeCommand($cmd) === 0){
            return;
        }
        $cmd->setRawArguments(array('views', $views+1));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('view:' . ($views+1), $this->id));
        $this->redis->executeCommand($cmd);
        $cmd = new Predis\Command\SetRemove();
        $cmd->setRawArguments(array('view:' . $views, $this->id));
        $this->redis->executeCommand($cmd);
        $card = new Predis\Command\SetCardinality();
        $card->setRawArguments(array('view:' . $views));
        if($this->redis->executeCommand($card) === 0){
            $cmd->setRawArguments(array('views', $views)); // Still SetRemove
            $this->redis->executeCommand($cmd);
        }
    }

    public function getViews(){
        $cmd = new Predis\Command\SetCardinality();
        $cmd->setRawArguments(array('page:' . $this->id . ':views'));
        return $this->redis->executeCommand($cmd);
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
        return $this->get('text');
    }

    public function getDescription(){
        return $this->get('description');
    }

    public function getTitle(){
        return $this->get('title');
    }

    public function getUsername(){
        return $this->get('username');
    }

    public function getIP(){
        // We probably won't use this, but it's good to have it, just in case bad things happen.
        return $this->get('ip');
    }

    public function getTitleSlug(){
        return ($slug = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('-','-','-'), $this->getTitle()))) == '' ? 'Untitled' : $slug;
    }

    public function getCategory(){
        return $this->get('category');
    }

    public function getFiles(){
        $cmd = new Predis\Command\SetMembers();
        $cmd->setRawArguments(array('file:' . $this->id));
        return $this->redis->executeCommand($cmd);
    }

    public function getId(){
        return $this->id;
    }

    private function get($name){
        $cmd = new Predis\Command\StringGet();
        $cmd->setRawArguments(array('page:' . $this->id . ':' . $name));
        return $this->redis->executeCommand($cmd);
    }

    public function __toString(){
        $data = array('success' => 1,
              'data' => array(
                  'id' => $this->getId(),
                  'title' => $this->getTitle(),
                  'description' => $this->getDescription(),
                  'tags' => $this->getTags(),
                  'category' => $this->getCategory(),
                  'title-slug' => $this->getTitleSlug(),
                  //'ip' => $this->getIP(),
                  'username' => $this->getUsername(),
                  'text' => $this->getText()
              )
        );
        return json_encode($data);
    }
}
