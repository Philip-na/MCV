<?php

class Controller{

    protected $entityId;
    public $template;
    public $dbc;

    function runAction($actionName){

        $mthd = 'runBeforeAction';
        if (method_exists($this, 'runBeforeAction')){
            $result = $this->$mthd();
            if ($result == false){
                return;
            }
        }
        
        $actionName .= 'Action';
        if (method_exists($this, $actionName)){
            $this->$actionName();
        }else{
            include 'veiw/status/404.html';
        }
    }

    public function setEntityId($entityId){
        $this->entityId = $entityId;
    }
}