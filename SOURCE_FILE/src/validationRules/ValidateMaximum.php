<?php

class ValidateMaximum implements ValidationRuleInterface {
    private $maximum;

    public function __construct($min)
    {
        $this->maximum = $min;
    }
    function validateRule($value){
          //  min
          if(strlen($value)>$this->maximum){
            return false;
        }
        return true;
    }

    public function getErrorMessage()
    {
        return "must be greater than " . $this->maximum;
    }
}
