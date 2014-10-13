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

    private $peregrine;

    public function __construct(){
        global $redis;
        $this->redis = $redis;
        include_d('../Markdown/Michelf/MarkdownExtra.php');
        $this->md = new \Michelf\MarkdownExtra();
        include_d("../Peregrine/Peregrine.php");
        $this->peregrine = new Peregrine;
        $this->peregrine->init();
    }

    public function getPeregrine(){
        return $this->peregrine;
    }

    /**
     * Get a page object for the given id.
     * @param int $id The tutorial id
     * @return Page the page object so we can get information.
     */
    public function page($id){
        if(!class_exists('Page')){
            include('Predis_Page.class.php');
        }
        return new Page($id, $this);
    }

    public function random(){
        $cmd = new Predis\Command\SetRandomMember();
        $cmd->setRawArguments(array('pages'));
        return $this->page($this->redis->executeCommand($cmd));
    }

    /**
     * Print out the nice HTML of a tutorial.
     *
     * @param Page $tutorial
     */
    public function html_printTutorial(Page $tutorial){
        print($this->doReplaces('
            <div class="tutorial">
                <h2 class="tutorial-header"><!--<a class="tutorial-link" href="/tutorial/%slug%/%id%/">--><a href="%categorylink%">[%category%]</a> <b>%title%</b><!--</a>--></h2>
                <span class="tutorial-description">%desc%</span><br/>
                <i>by %user%</i><hr/>
                <div class="tutorial-text">
                      <span class="full-text" id="tutorial-id-%id%">%ftext%</span>
                </div>
                <!--<br/>
                <hr/>
                <span><a href="/edit/%id%/">Edit this page! (admins only)</a></span>-->
            </div>
            <br/><br/>
        ', $tutorial));
    }

    public function html_printSample(Page $tutorial){
        print($this->doSimpleReplaces('
            <a class="link" href="/tutorial/%id%/%slug%/">
                <div class="tutorial-sample">
                    <h4 class="tutorial-link-sample tutorial-header">%title%</h4>
                    <span class="tutorial-description-sample">%desc%</span><br/>
                    <!--<code class="tutorial-author-sample">by %user%</code>-->
                </div>
            </a>
        ', $tutorial));
    }

    public function html_printTutorialLink(Page $tutorial){
        print $this->doReplaces('
            <div class="tutorial">
                <a class="link" href="/tutorial/%id%/%slug%/">
                    <div>
                        <h2 class="tutorial-header tutorial-link">%title%</h2>
                        <span class="tutorial-description">%desc%</span>
                        <br/>
                    </div>
                </a>
                <!--<code class="tutorial-author">by %user%</code>--><hr/>
                <div class="tutorial-text">
                      <span class="truncated-text" id="tutorial-id-%id%">%ttext%</span>
                </div>
                <br/>
            </div>
            <br/><br/>
        ', $tutorial);
    }

    private function doReplaces($string, Page $tutorial){
        $text = $tutorial->getText();
        $category = $tutorial->getCategory();
        $replaces = array(
            '%id%' => $tutorial->getId(),
            '%slug%' => $tutorial->getTitleSlug(),
            '%title%' => htmlspecialchars($tutorial->getTitle()),
            '%desc%' => htmlspecialchars($tutorial->getDescription()),
            '%user%' => htmlspecialchars($tutorial->getUsername()),
            '%ttext%' => /*preg_replace("/{.*?}/g", "", */$this->md->defaultTransform(strlen($text) > 250 ? substr($text, 0, 250) . '...' : $text)/*)*/,
            '%ftext%' => $this->md->defaultTransform($this->syntax($text)),
            '%category%' => ucwords(htmlspecialchars($category)),
            '%categorylink%' => '/category/' . str_replace(' ', '+', ucwords(htmlspecialchars($category))) . '/',
            '%views%' => $tutorial->getViews()
        );
        foreach($replaces as $key => $val){
            $string = str_replace($key, $val, $string);
        }
        return $string;
    }

    private function doSimpleReplaces($string, Page $tutorial){
        $replaces = array(
            '%id%' => $tutorial->getId(),
            '%slug%' => $tutorial->getTitleSlug(),
            '%title%' => htmlspecialchars($tutorial->getTitle()),
            '%desc%' => htmlspecialchars($tutorial->getDescription()),
            '%user%' => htmlspecialchars($tutorial->getUsername()),
            '%category%' => htmlspecialchars(ucwords($tutorial->getCategory())),
            '%views%' => $tutorial->getViews()
        );
        foreach($replaces as $key => $val){
            $string = str_replace($key, $val, $string);
        }
        return $string;
    }

    public function syntax($text){
        $text = str_replace('<', '&lt;', $text);
        $text = str_replace('>', '&gt;', $text);
        $langs = array('c', 'shell', 'java', 'd', 'coffeescript', 'generic', 'scheme', 'javascript', 'r', 'haskell', 'python', 'html', 'smalltalk', 'csharp', 'go', 'php', 'ruby', 'lua', 'css', 'terminal');
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

        $text = str_replace('{red}', '<span class="red">', $text);
        $text = str_replace('{/red}', '</span>', $text);
        return $text;
    }

    public function getMarkdown(){
        return $this->md;
    }

    public function html_printTags(Page $tutorial){
        $tags = $tutorial->getTags();
        if(empty($tags)){return "";}
        $return = "<h4 class='tag-header'>Tags</h4><hr class='tag-hr'/>";
        $return .= '<ul class="tags blue">';
        foreach($tags as $tag){
            $return .= sprintf('<li><a href="/tag/%s/">%s <span>%s</span></a></li>', str_replace(' ', '+', $tag), $tag, sizeof($this->tagged($tag)));
        }
        $return .= '</ul>';
        return $return;
    }

    public function html_attachments(Page $tutorial){
        $files = $tutorial->getFiles();
        if(empty($files)){return "";}
        $return = "";
        $return .= '<h4 class="tag-header">Attachments</h4><hr class="tag-hr"/><ul>';
        foreach($tutorial->getFiles() as $file){
            $fileName = $this->attachmentName($tutorial->getId(), $file);
            $return .= sprintf('<li><a href="/_file/%s/%s/%s">%s</a></li>', $tutorial->getId(), $file, $fileName, $fileName);
        }
        $return .= '</ul><hr style="border-color: white; border-width: 1px; margin-left: -5%; margin-right: -5%;"/>';
        return $return;
    }

    public function attachmentText($id, $subid){
        $cmd = new Predis\Command\StringGet();
        $cmd->setRawArguments(array('file:' . $id . ':' . $subid . ':text'));
        return $this->redis->executeCommand($cmd);
    }

    public function attachmentName($id, $subid){
        $cmd = new Predis\Command\StringGet();
        $cmd->setRawArguments(array('file:' . $id . ':' . $subid . ':name'));
        return $this->redis->executeCommand($cmd);
    }

    public function tagged($tag){
        $cmd = new Predis\Command\SetMembers();
        $cmd->setRawArguments(array('tag:' . strtolower($tag)));
        return $this->redis->executeCommand($cmd);
    }

    public function categorized($category){
        $cmd = new Predis\Command\SetMembers();
        $cmd->setRawArguments(array('category:' . strtolower($category)));
        return $this->redis->executeCommand($cmd);
    }

    public function search($terms/*, $limit = -1, $pagination = 1*/){
        $terms = preg_replace('/[^A-Za-z0-9 ]/', ' ', $terms); // Replace weird characters with a " ".
        $words = explode(' ', strtolower($terms));
        $categorized = array();
        $tagged = array();
        foreach($words as $word){
            $categorized = array_merge($categorized, $this->categorized($word));
            $tagged = array_merge($tagged, $this->tagged($word));
        }
        $result = array_merge($categorized, $tagged);
        $result = array_unique($result);
        return /*$this->shorten(*/$result/*, $limit, $pagination)*/;
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
    public function getAllPages($limit = -1, $pagination = 1, $reverse = false){
        $cmd = new Predis\Command\SetMembers();
        $cmd->setRawArguments(array('pages'));
        $pages = $this->redis->executeCommand($cmd);
        sort($pages);
        $pages = $reverse ? array_reverse($pages) : $pages;
        return $this->shorten($pages, $limit, $pagination);
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

    public function popular($limit = -1, $pagination = 1){
        $cmd = new Predis\Command\SetMembers();
        $cmd->setRawArguments(array('views'));
        $array = $this->redis->executeCommand($cmd);
        rsort($array, SORT_NUMERIC);
        $result = array();
        foreach($array as $amt){
            $cmd->setRawArguments('view:' . $amt);
            foreach($this->redis->executeCommand($cmd) as $id){
                $result[] = $id;
            }
        }
        return $this->shorten($result, $limit, $pagination);
    }

    public function quickPopular($limit = 5){
        $cmd = new Predis\Command\SetMembers();
        $cmd->setRawArguments(array('views'));
        $array = $this->redis->executeCommand($cmd);
        rsort($array, SORT_NUMERIC);
        $result = array();
        foreach($array as $amt){
            $cmd->setRawArguments(array('view:' . $amt));
            foreach($this->redis->executeCommand($cmd) as $id){
                $result[] = $id;
                if(sizeof($result) >= $limit){
                    return $result;
                }
            }
        }
        return $result;
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
            $tag = strtolower($tag);
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

    public function categorySearch($pages, $category, $limit=-1, $pagination=1){
        foreach($pages as $id => $page){
            $cmd = new Predis\Command\SetIsMember();
            $cmd->setRawArguments(array('category:' . $category, $page));
            if(!$this->redis->executeCommand($cmd)){
                unset($pages[$id]);
            }
        }
        return $this->shorten($pages, $limit, $pagination);
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
    public function create($title = "New Tutorial", $description = "Tutorial description", $text = "Tutorial", $tags = array(), $distro = "all", $username = "Anonymous", $ip = "Unknown"){

        // First, let's just initialize the database. This is pretty simple, but you can comment it out after there are things in the database.
        // I'll do that later
        $cmd = new Predis\Command\KeyExists();
        $cmd->setRawArguments(array('next_id'));
        if(!$this->redis->executeCommand($cmd)){
            $cmd = new Predis\Command\StringSet();
            $cmd->setRawArguments(array('next_id', 1)); // There's no current page, so we start at 0.
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
            if($tag == "") continue;
            $cmd = new Predis\Command\SetAdd();
            $cmd->setRawArguments(array('tags', $tag)); // We can use this because if it already exists, it is not added, it returns 0.
            $this->redis->executeCommand($cmd);
            $cmd->setRawArguments(array('tag:' . $tag, $id)); // Add the id to the tag
            $this->redis->executeCommand($cmd);
        }
        $cmd = new Predis\Command\SetAdd();
        $cmd->setRawArguments(array('pages', $id));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('views', 0));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('view:0', $id));
        $this->redis->executeCommand($cmd);

        return $id;
    }

    public function edit($id, $title, $description, $text, $tags, $distro, $username, $ip){ // TODO add defaults.
        // String data of the tutorial
        $cmd = new Predis\Command\StringSet();

        $cmd->setRawArguments(array('page:' . $id . ':title', $title));
        $this->redis->executeCommand($cmd);

        $cmd->setRawArguments(array('page:' . $id . ':description', $description));
        $this->redis->executeCommand($cmd);

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
            $rem = new Predis\Command\SetMembers();
            $rem->setRawArguments(array('category:' . $aDistro));
            if(sizeof($this->redis->executeCommand($rem)) == 0){
                $rem = new Predis\Command\SetRemove();
                $rem->setRawArguments(array('categories', $aDistro));
                $this->redis->executeCommand($rem);
            }
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
            $rem = new Predis\Command\SetMembers();
            $rem->setRawArguments(array('tag:' . $tag));
            if(sizeof($this->redis->executeCommand($rem)) == 0){
                $rem = new Predis\Command\SetRemove();
                $rem->setRawArguments(array('tags', $tag));
                $this->redis->executeCommand($rem);
            }
        }
        // Tags of the page
        foreach($tags as $tag){
            if($tag == "") continue;
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
            $rem = new Predis\Command\SetMembers();
            $rem->setRawArguments(array('tag:' . $tag));
            if(sizeof($this->redis->executeCommand($rem))){
                $rem = new Predis\Command\SetRemove();
                $rem->setRawArguments(array('tags', $tag));
                $this->redis->executeCommand($rem);
            }
        }
        $cmd->setRawArguments(array('categories'));
        foreach($this->redis->executeCommand($cmd) as $distro){
            $rem = new Predis\Command\SetRemove();
            $rem->setRawArguments(array('category:' . $distro, $id));
            $this->redis->executeCommand($rem);
            $rem = new Predis\Command\SetMembers();
            $rem->setRawArguments(array('category:' . $distro));
            if(sizeof($this->redis->executeCommand($rem)) == 0){
                $rem = new Predis\Command\SetRemove();
                $rem->setRawArguments(array('categories', $distro));
                $this->redis->executeCommand($rem);
            }
        }
        $cmd = new Predis\Command\SetCardinality();
        $cmd->setRawArguments(array('page:' . $id . ':views'));
        $views = $this->redis->executeCommand($cmd);
        $cmd = new Predis\Command\SetRemove();
        $cmd->setRawArguments(array('view:' . $views, $id));
        $this->redis->executeCommand($cmd);
        $card = new Predis\Command\SetCardinality();
        $card->setRawArguments(array('view:' . $views));
        if($this->redis->executeCommand($card) === 0){
            $cmd->setRawArguments(array('views', $views)); // Still SetRemove
            $this->redis->executeCommand($cmd);
        }
        $cmd = new Predis\Command\SetRemove();
        $cmd->setRawArguments(array('pages', $id));
        $this->redis->executeCommand($cmd);
    }

    /*
     * FILES
     */

    public function attach($text="#!/bin/bash\r\necho An Error occurred saving this file. Sorry.", $id = -1, $name = "hello-world.txt"){
        $thisid = max($this->page($id)->getFiles()) + 1;
        $cmd = new Predis\Command\SetAdd();
        $cmd->setRawArguments(array('file:' . $id, $thisid));
        $this->redis->executeCommand($cmd);
        $cmd = new Predis\Command\StringSet();
        $cmd->setRawArguments(array('file:' . $id . ':' . $thisid . ':text', $text));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('file:' . $id . ':' . $thisid . ':name', $name));
        $this->redis->executeCommand($cmd);
    }

    public function detach($id, $thisid){
        $cmd = new Predis\Command\SetRemove();
        $cmd->setRawArguments(array('file:' . $id, $thisid));
        $this->redis->executeCommand($cmd);
        $cmd = new Predis\Command\KeyDelete();
        $cmd->setRawArguments(array('file:' . $id . ':' . $thisid . ':text'));
        $this->redis->executeCommand($cmd);
        $cmd->setRawArguments(array('file:' . $id . ':' . $thisid . ':name'));
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
     *
     * "file:pageid:subid:(text|name)" STRING("the text or filename")
     * "file:pageid" SET(1, 2, 5, 6, subids)
     *
     * // We might be able to have category:<catname>:pic link to a picture of the logo of that category.
     *
     * "next_id" string(id of the next page we will add)
     */

}
