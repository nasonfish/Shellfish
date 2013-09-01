<?php

function include_e($page = false, $pass = array(), $tutorials){
    if($page !== false && file_exists($page)){
        include($page);
        return true;
    }
    return false;
}

class PageHandler {

    private $template;
    private $pass;
    private $tutorials;

    /**
     * Handle the page.
     * @param string $template The name of the page we're using
     * @param array $pass What variables to pass along
     */
    public function __construct($template = "index", $pass = array()){
        require('Tutorials.class.php');
        require('Predis_Page.class.php');
        require('PredisPageDoesNotExistException.php');
        $this->template = $template;
        $this->tutorials = new Tutorials;
        $this->pass = $pass;
        include('../templates/main_tpl.php');
    }

    public function head(){
        include_e('../templates/' . $this->template . '_tpl.head.php', $this->pass, $this->tutorials);
    }

    public function foot(){
        include_e('../templates/' . $this->template . '_tpl.foot.php', $this->pass, $this->tutorials);
    }

    public function js(){
        include_e('../templates/' . $this->template . '_tpl.js.php', $this->pass, $this->tutorials);
    }

    public function css(){
        include_e('../templates/' . $this->template . '_tpl.css.php', $this->pass, $this->tutorials);
    }

    public function page(){
        if(!include_e('../templates/' . $this->template . '_tpl.php', $this->pass, $this->tutorials)){
            $template = $this->template;
            include('../templates/404_tpl.php');
            //echo "<br/>I couldn't find the page you were looking for, sorry. Maybe you should head <a href='/'>home</a> and find your way back to where you were.<br/><br/>";// Let nasonfish &lt;nasonfish [at] gmail {dot} com&gt; know if you believe this is a mistake.";
        }
    }

    public function active($page = "index"){
        if($this->template == $page){
            return "active";
        }
        return "";
    }
}