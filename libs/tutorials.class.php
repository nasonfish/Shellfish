<?php
/**
 * Our class for handling all the backend stuff for us.
 * Class Tutorials
 */

class Tutorials {

    public $tutorials = false;

    public function __construct(){
        $this->parseXML();
    }

    private function parseXML(){
        $file = "../pages.xml";
        $xml = simplexml_load_file($file);
        if(!$xml){
            print "Sorry, an error occurred with the XML file gathering the tutorials. Please notify an admin person.";
        }
        $this->tutorials = $xml;
    }

    /**
     * We can't splice because it's not an array.
     * 0 - $amount - 1
     * @param bool $amount
     * @return array
     */
    public function first($amount = false){
        //return array_slice($this->tutorials, 0, $amount);
        $return = array();
        for($i = 0; $i < $amount; $i++){
            if(!empty($this->tutorials->page[$i])){
                $return[] = $this->tutorials->page[$i];
            }
        }
        return $return;
    }

    public function byTag($tag = false, $amount = false){
        $return = array();
        foreach($this->tutorials as $page){
            if(sizeof($return) >= $amount){
                break;
            }
            foreach($page->tags as $pageTag){
                if($pageTag == $tag){
                    $return[] = $page;
                    continue 2;
                }
            }
        }
    }

    /**
     * Print out the nice text of a tutorial.
     * @param bool $tutorial
     */
    public function printTut($tutorial = false, $all = false){
        $text = file_get_contents('../pages/' . $tutorial->file);
        print '
            <div class="tutorial">
                <h3 class="tutorial-header"><a class="tutorial-link" href="/tutorial.php?id='.$tutorial->id.'">'.$tutorial->title.'</a></h3>
                <span class="tutorial-description"><i>'.$tutorial->description.'</i></span>
                <div class="tutorial-text">
                    <pre class="tutorial">
                        <span class="truncatedtext">
'.htmlentities(substr($text, 0, 150)).($all ? '' : '<span class="dotdot" id="tutorial-id-'.$tutorial->id.'-dot">...</span><span class="fulltext" id="tutorial-id-'.$tutorial->id.'">').htmlentities(substr($text, 150)).'
                        </span>
                        </span>

                    </pre>
                    '.($all ? '' : '<a class="showall" for="tutorial-id-'.$tutorial->id.'">Show full tutorial</a>').'
                </div>
            </div>
        ';
    }

    public function getTut($id = false){
        //if(!empty($id)){
            foreach($this->tutorials->page as $page){
                if($page->id == $id){
                    return $page;
                }
            }
            return false;
        //}
        //return false;
    }

    public function dlLink($id = false){
        $tutorial = $this->getTut($id);
        if($tutorial){
            if($tutorial->download){
                return '<a href="/dl.php?id='.$id.'">Download me!</a>';
            }
        }
    }

}