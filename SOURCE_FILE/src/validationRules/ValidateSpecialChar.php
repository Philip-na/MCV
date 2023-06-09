<?php

class ValidateSpecialChar implements ValidationRuleInterface {
    private $rule;

    public function __construct($rule = "/[^a-zA-Z0-9]+/")
    {
        $this->rule = $rule;
    }
    function validateRule($value){
        if(!preg_match($this->rule, $value)){
            var_dump('invalid pass');
            return false;
        }
        return true;
         
    }
    function getErrorMessage(){
        return 'must contian lowercase, upercase, a number and special char';
    }
}
