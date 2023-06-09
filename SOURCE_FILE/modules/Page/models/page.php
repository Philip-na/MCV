<?php

class Page extends Entity {
  

    public function __construct($dbc)
    {
       parent::__construct($dbc, 'page');

        
    }
    protected function tableFields(){
        $this->fields = [
            'title',
            'content'
           
        ];
    }

   
}