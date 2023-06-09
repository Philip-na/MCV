<?php

class Template {
    private $layout;

    public function __construct($layout)
    {
        $this->layout = $layout;
    }

    function view($template, $variable){

        include VIEW_PATH . $this->layout. '.html';
    }
}