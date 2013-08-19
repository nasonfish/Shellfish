<?php

function include_e($page = false, $pass = array()){
    if($page !== false && file_exists($page)){
        foreach($pass as $key => $val){
            $$key = $val;
        }
        include($page);
    }
}

class PageHandler {

    private $template;
    private $pass;

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
        $pass['tutorials'] = new Tutorials;
        $this->pass = $pass;
        include('../templates/main_tpl.php');
    }

    public function head(){
        include_e('../templates/' . $this->template . '_tpl.head.php', $this->pass);
    }

    public function foot(){
        include_e('../templates/' . $this->template . '_tpl.foot.php', $this->pass);
    }

    public function js(){
        include_e('../templates/' . $this->template . '_tpl.js.php', $this->pass);
    }

    public function css(){
        include_e('../templates/' . $this->template . '_tpl.css.php', $this->pass);
    }

    public function page(){
        include_e('../templates/' . $this->template . '_tpl.php', $this->pass);
    }
}