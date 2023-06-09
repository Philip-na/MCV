<?php
class DashboardController extends Controller{


    function runBeforeAction(){
      if($_SESSION['is_admin'] ?? false == true){
        return true;
      }
      $action = $_GET['action'] ?? $_POST['action'] ?? 'default';
      if($action != 'login'){
        header('Location: index.php?module=dashboard&action=login');
      }else{
        return true;
      }
      
    
    }
// defalute action


    function defaultAction(){


      header('Location: index.php?module=page');
      exit();
      
    
    }

    function loginAction(){
      if($_POST['postAction'] ?? 0 == 1){
        $username = $_POST['username'] ?? '';
        $password =$_POST['password'] ?? '';

        $validation = new Validation();
        
        if(!$validation
                ->addRule(new ValidateMinimum(3))
                ->addRule(new ValidateMaximum(20))
                // ->addRule(new ValidateSpecialChar())
                ->validate($password)){
                  $_SESSION['validation']['errors'] = $validation->getAllErrorMessages();
        }

        if(!$validation
                ->addRule(new ValidateMinimum(3))
                ->addRule(new ValidateMaximum(20))
                // ->addRule(new ValidateEmail())
                ->validate($username)){
                  $_SESSION['validation']['errors'] = $validation->getAllErrorMessages();

        }

        if(($_SESSION['validation']['error'] ?? '') == ''){
          $auth = new Auth();
          if($auth->checkLogin($username, $password)){
            // all is good
            $_SESSION['is_admin'] = 1;
            header('Location: index.php');
            exit();
          }
          // $errors = ['username or password wrong'];
          // $_SESSION['validation']['errors'] = $errors;
        }
       
       
        // var_dump('bad login');
      }



      include VIEW_PATH . 'admin/login.html';
      unset($_SESSION['validation']['errors']);
    }
}



