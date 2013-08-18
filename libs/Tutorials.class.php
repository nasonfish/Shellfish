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

    private $predisInterface;

    public function __construct(){
        include('Predis_Interface.class.php');
        $this->predisInterface = new Predis_Interface;
    }

    /**
     * Print out the nice text of a tutorial.
     * @param bool $tutorial
     */
    public function printTut(Page $tutorial, $all = false){
        print '
            <div class="tutorial">
                <h3 class="tutorial-header"><a class="tutorial-link" href="/tutorial.php?id='.$tutorial->getId().'">'.$tutorial->getTitle().' (by '.$tutorial->getUsername().')</a></h3>
                <span class="tutorial-description"><i>'.$tutorial->getDescription().'</i></span>
                <div class="tutorial-text">
                    <pre class="tutorial">
                        <span class="truncatedtext">
'.htmlentities(substr($tutorial->getText(), 0, 150)).($all ? '' : '<span class="dotdot" id="tutorial-id-'.$tutorial->getId().'-dot">...</span><span class="fulltext" id="tutorial-id-'.$tutorial->getId().'">').htmlentities(substr($text, 150)).'
                        </span>
                        </span>

                    </pre>
                    '.($all ? '' : '<a class="showall" for="tutorial-id-'.$tutorial->getId().'">Show full tutorial</a>').'
                </div>
            </div>
        ';
    }

    public function getPredisInterface(){
        return $this->predisInterface;
    }

    public function dlLink(Page $tutorial){
        if($tutorial){
            if($tutorial->getDownload()){
                return '<a href="/dl.php?id='.$tutorial->getId().'">Download me!</a>';
            }
        }
        return '';
    }

}