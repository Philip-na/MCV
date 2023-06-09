<?php

class Auth {
    function checkLogin($username, $password){
        $dbh = DatabaseConnection::getInstance();
        $dbc = $dbh->getConnection();

        $userObj = new User($dbc);
        $userObj->findBy('username', $username);
        // var_dump($userObj);
        if(property_exists($userObj, 'id')){
            if($userObj->password == md5($password)){
                // all is good
                return true;
            }
        }
    }
}