<?php

class ValidateMinimum implements ValidationRuleInterface {
    private $minimum;

    public function __construct($min)
    {
        $this->minimum = $min;
    }
    function validateRule($value){
          //  min
         if(strlen($value)<$this->minimum){
            return false;
         }
       
         return true;
    }
    function getErrorMessage(){
        return 'must not be less than' . $this->minimum;;
    }
}
