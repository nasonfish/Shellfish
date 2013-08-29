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
 * Our class for handling all the backend stuff for us.
 * Class Tutorials
 */


class Tutorials {

    private $redis;

    private $md;

    public function __construct(){
        require 'Predis/Autoloader.php';
        include '../Markdown/Michelf/MarkdownExtra.php';
        Predis\Autoloader::register();
        $pass = trim(file_get_contents('../redispass.txt'));
        $this->redis = new Predis\Client();
        $auth = new Predis\Command\ConnectionAuth();
        $auth->setRawArguments(array($pass));
        $this->redis->executeCommand($auth);
        $this->md = new \Michelf\MarkdownExtra();
    }

    /**
     * Get a page object for the given id.
     * @param int $id The tutorial id
     * @return Page the page object so we can get information.
     */
    public function page($id){
        return new Page($id, $this);
    }

    /**
     * Print out the nice HTML of a tutorial.
     *
     * @param Page $tutorial
     */
    public function html_printTutorial(Page $tutorial){
        print($this->doReplaces('
            <div class="tutorial">
                <h3 class="tutorial-header"><!--<a class="tutorial-link" href="/t/%slug%/%id%/">-->[%category%] <b>%title%</b><!--</a>--></h3>
                <span class="tutorial-description"><i>%desc%</i></span><br/>
                <p class="tutorial-author">by %user%</p><hr/>
                <div class="tutorial-text">
                      <span class="full-text" id="tutorial-id-%id%">%ftext%</span>
                </div>
                <br/>
                <hr/>
                <span><a href="/edit/%id%/">Edit this page! (admins only)</a></span>
            </div>
            <br/><br/>
        ', $tutorial));
    }

    public function html_printTutorialLink(Page $tutorial){
        print $this->doReplaces('
            <div class="tutorial">
                <h3 class="tutorial-header">[%category%] <a class="tutorial-link" href="/t/%slug%/%id%/"><b>%title%</b></a></h3>
                <span class="tutorial-description"><i>%desc%</i></span><br/>
                <p class="tutorial-author">by %user%</p><hr/>
                <div class="tutorial-text">
                      <span class="truncated-text" id="tutorial-id-%id%">%ttext%...</span>
                      <a href="/t/%slug%/%id%/">See full tutorial</a>
                </div>
                <br/>

            </div>
            <br/><br/>
        ', $tutorial);
    }

    private function doReplaces($string, Page $tutorial){
        $replaces = array(
            '%id%' => $tutorial->getId(),
            '%slug%' => $tutorial->getTitleSlug(),
            '%title%' => $tutorial->getTitle(),
            '%desc%' => $tutorial->getDescription(),
            '%user%' => $tutorial->getUsername(),
            '%ttext%' => $this->md->defaultTransform($this->syntax(substr($tutorial->getText(), 0, 250))),
            '%ftext%' => $this->md->defaultTransform($this->syntax($tutorial->getText())),
            '%category%' => $tutorial->getCategory()
        );
        foreach($replaces as $key => $val){
            $string = str_replace($key, $val, $string);
        }
        return $string;
    }

    private function syntax($text){
        $text = str_replace('<', '&lt;', $text);
        $text = str_replace('>', '&gt;', $text);
        $langs = array('c', 'shell', 'java', 'd', 'coffeescript', 'generic', 'scheme', 'javascript', 'r', 'haskell', 'python', 'html', 'smalltalk', 'csharp', 'go', 'php', 'ruby', 'lua', 'css');
        foreach($langs as $lang){
            $text = str_replace('{'.$lang.'}', '<pre data-language="'.$lang.'">', $text);
            $text = str_replace('{/'.$lang.'}', '</pre>', $text); // bad :/
        }
        foreach(array('info', 'error', 'success', 'danger') as $div){
            $text = str_replace('{'.$div.'}', '<div class="alert alert-'.$div.'">', $text);
            $text = str_replace('{/'.$div.'}', '</div>', $text);
        }
        $text = str_replace('{alert}', '<div class="alert">', $text);
        $text = str_replace('{/alert}', '</div>', $text);
        return $text;
    }

    public function html_downloadLink(Page $tutorial){
        // <a target="_blank" href="/dl.php?id='.$tutorial->getId().'"
        if($tutorial){
            if($tutorial->getDownload()){
                return sprintf('<button class="download" onclick="location.href=\'/dl.php?id=%s\'">Do it for me!</button>', $tutorial->getId());
            }
        }
        return '';
    }

    public function html_printTags(Page $tutorial){
        $return = "<p>Tags: ";
        foreach($tutorial->getTags() as $tag){
            $return .= '<a href="/tagsearch/'.$tag.'/">' . $tag . '</a>&nbsp;';
        }
        $return .= "</p>";
        return $return;
    }

    /**
     * Get the Predis Client that you can use
     * to execute queries.
     *
     * @return \Predis\Client
     */
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

    /**
     * Get all of the pages in the database.
     *
     * @param int $limit Is there a limit to how many we should have? (also, amount per page). < 0 for all of them
     * @param int $pagination What page are we on?
     * @return array Page ids
     */
    public function getAllPages($limit = -1, $pagination = 1){
        $cmd = new Predis\Command\SetMembers();
        $cmd->setRawArguments(array('pages'));
        return $this->shorten($this->redis->executeCommand($cmd), $limit, $pagination);
    }

    /*
     * Small utility function that shortens an array.
     */
    private function shorten($pages, $limit, $pagination){
        if(!is_array($pages)){
            return array();
        }
        if($limit < 0){
            return $pages;
        }
        return array_slice($pages, $limit * ($pagination-1), $limit);
    }

    /**
     * Filter tutorials that have a certain [set of] tag[s]
     *
     * @param array $tags Array of strings, for the tags we search for
     * @param int $limit A limit to how many we should return. < 0 means return all. also per-page
     * @param int $pagination Pagination page.
     * @return array Array of integers, ids of pages that match all tags.
     */
    public function tagSearch($pages, $tags = array(), $limit = -1, $pagination = 1){
        $results = array();
        foreach($tags as $tag){
            $results[$tag] = array();
            $command = new Predis\Command\SetIsMember();
            $command->setRawArguments(array('tags', $tag));
            if(!$this->redis->executeCommand($command)){
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
        return $return === false ? array() : $this->shorten($return, $limit, $pagination);
    }

    public function categorySearch($pages, $distro, $limit=-1, $pagination=1){
        $distros = array($distro, 'all');
        $results = array();
        foreach($distros as $d){
            $results[$d] = array();
            foreach($pages as $page){
                $cmd = new Predis\Command\SetIsMember();
                $cmd->setRawArguments(array('category:' . $d, $page));
                if($this->redis->executeCommand($cmd)){
                    $results[$d][] = $page;
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
        return $return === false ? array() : $this->shorten($return, $limit, $pagination);
    }

    public function getCategories(){
        return $this->getSet('categories');
    }

    public function getTags(){
        return $this->getSet('tags');
    }

    public function getSet($type){
        $cmd = new Predis\Command\SetMembers();
        $cmd->setRawArguments(array($type));
        return $this->redis->executeCommand($cmd);
    }

    /**
     * Create a new tutorial
     * @param string $title Our title
     * @param string $description Description, subtitle, etc.
     * @param string $text All the text inside the tutorial.
     * @param bool $download Download text, or false if there is none. We can have them download bash scripts to run.
     * @param array $tags An array of tags that we apply to the tutorial.
     * @param string $distro
     * @param string $compatible
     * @param string $username The username who submitted it, from the http auth.
     * @param string $ip The ip of the user who submitted it. We can use this if bad things happen.
     * @return int|mixed|\Predis\ResponseObjectInterface Integer, the id of the page we just created.
     */
    public function create($title = "New Tutorial", $description = "Tutorial description", $text = "Tutorial", $download = false, $tags = array(), $distro = "all", $username = "Anonymous", $ip = "Unknown"){

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
        if($download != false){
            $cmd->setRawArguments(array('page:' . $id . ':download', $download));
            $this->redis->executeCommand($cmd);
        }
        $cmd->setRawArguments(array('page:' . $id . ':text', $text));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('page:' . $id . ':username', $username));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('page:' . $id . ':ip', $ip));
        $this->redis->executeCommand($cmd);

        $cmd->setRawArguments(array('page:' . $id . ':category', $distro));
        $this->redis->executeCommand($cmd);
        $cmd = new Predis\Command\SetAdd();
        $cmd->setRawArguments(array('categories', $distro));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('category:' . $distro, $id));
        $this->redis->executeCommand($cmd);

        // Tags of the page
        foreach($tags as $tag){
            $cmd = new Predis\Command\SetAdd();
            $cmd->setRawArguments(array('tags', $tag)); // We can use this because if it already exists, it is not added, it returns 0.
            $this->redis->executeCommand($cmd);
            $cmd->setRawArguments(array('tag:' . $tag, $id)); // Add the id to the tag
            $this->redis->executeCommand($cmd);
        }
        $cmd = new Predis\Command\SetAdd();
        $cmd->setRawArguments(array('pages', $id));
        $this->redis->executeCommand($cmd);

        return $id;
    }

    public function edit($id, $title, $description, $text, $download, $tags, $distro, $username, $ip){ // TODO add defaults.
        // String data of the tutorial
        $cmd = new Predis\Command\StringSet();

        $cmd->setRawArguments(array('page:' . $id . ':title', $title));
        $this->redis->executeCommand($cmd);

        $cmd->setRawArguments(array('page:' . $id . ':description', $description));
        $this->redis->executeCommand($cmd);

        /* Download */
        if($download != false){
            $cmd->setRawArguments(array('page:' . $id . ':download', $download));
            $this->redis->executeCommand($cmd);
        } else {
            $rem = new Predis\Command\KeyDelete();
            $rem->setRawArguments(array('page:' . $id . ':download'));
            $this->redis->executeCommand($rem);
        }

        $cmd->setRawArguments(array('page:' . $id . ':text', $text));
        $this->redis->executeCommand($cmd);

        $cmd->setRawArguments(array('page:' . $id . ':username', $username));
        $this->redis->executeCommand($cmd);

        $cmd->setRawArguments(array('page:' . $id . ':ip', $ip));
        $this->redis->executeCommand($cmd);

        /* Category */
        $cmd->setRawArguments(array('page:' . $id . ':category', $distro));
        $this->redis->executeCommand($cmd);
        $distro = explode(' ', $distro);
        $distro = $distro[0];
        $cmd = new Predis\Command\SetMembers();
        $cmd->setRawArguments(array('categories'));
        foreach($this->redis->executeCommand($cmd) as $aDistro){
            $cmd = new Predis\Command\SetRemove();
            $cmd->setRawArguments(array('category:' . $aDistro, $id));
            $this->redis->executeCommand($cmd); // Maybe I shouldn't be doing this, but it doesn't care if it's not in the set already, it just gives me a return value of false.
        }
        $cmd = new Predis\Command\SetAdd();
        $cmd->setRawArguments(array('categories', $distro));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('category:' . $distro, $id));
        $this->redis->executeCommand($cmd);
        /* Tags */
        // Remove this tutorial from its old tags
        $cmd = new Predis\Command\SetMembers();
        $cmd->setRawArguments(array('tags'));
        foreach($this->redis->executeCommand($cmd) as $tag){
            $cmd = new Predis\Command\SetRemove();
            $cmd->setRawArguments(array('tag:' . $tag, $id));
            $this->redis->executeCommand($cmd); // Maybe I shouldn't be doing this, but it doesn't care if it's not in the set already, it just gives me a return value of false.
        }
        // Tags of the page
        foreach($tags as $tag){
            $cmd = new Predis\Command\SetAdd();
            $cmd->setRawArguments(array('tags', $tag)); // We can use this because if it already exists, it is not added, it returns 0.
            $this->redis->executeCommand($cmd);
            $cmd->setRawArguments(array('tag:' . $tag, $id)); // Add the id to the tag
            $this->redis->executeCommand($cmd);
        }
    }

    public function delete($id){
        $cmd = new Predis\Command\KeyDelete();
        $cmd->setRawArguments(array('page:' . $id . ':title'));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('page:' . $id . ':description'));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('page:' . $id . ':download'));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('page:' . $id . ':text'));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('page:' . $id . ':username'));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('page:' . $id . ':ip'));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('page:' . $id . ':category'));
        $this->redis->executeCommand($cmd);
        // Remove this tutorial from its old tags
        $cmd = new Predis\Command\SetMembers();
        $cmd->setRawArguments(array('tags'));
        foreach($this->redis->executeCommand($cmd) as $tag){
            $rem = new Predis\Command\SetRemove();
            $rem->setRawArguments(array('tag:' . $tag, $id));
            $this->redis->executeCommand($rem); // Maybe I shouldn't be doing this, but it doesn't care if it's not in the set already, it just gives me a return value of false.
        }
        $cmd->setRawArguments(array('categories'));
        foreach($this->redis->executeCommand($cmd) as $distro){
            $rem = new Predis\Command\SetRemove();
            $rem->setRawArguments(array('category:' . $distro, $id));
            $this->redis->executeCommand($rem);
        }
        $cmd = new Predis\Command\SetRemove();
        $cmd->setRawArguments(array('pages', $id));
        $this->redis->executeCommand($cmd);
    }

    /*
     * Okay, so here's our schema.
     * "tags" SET(tagname, othertag, blah)
     * "tag:<tagname>" SET(1, 2, 3, 4, ids_of_pages)
     *
     * "pages" SET(1, 2, 3, 4, ids_of_all_the_pages)
     * "page:<pageid>:(title|description|download|text|username|ip|cat)" string(the specified thing in a string.)
     *
     * "categories" SET(distroname, anotherdistro, onemoredistro, softwaare, blah)
     * "category:<catname>" SET(5, 2, 3, 5, ids_of_pages)
     * // We might be able to have category:<catname>:pic link to a picture of the logo of that category. "none"/"all"
     *
     * "next_id" string(id of the next page we will add)
     */

}