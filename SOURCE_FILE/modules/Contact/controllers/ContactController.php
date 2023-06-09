<?php

class ContactController extends Controller{

    function runBeforeAction(){
        if($_SESSION['has_sunmited_the_form'] ?? 0 ==1){

            // $variable['tiltle'] = 'You already submited the form';
            // $variable['content'] = 'we will get to you soon';
            

            // $dbh = DatabaseConnection::getInstance();
            // $dbc = $dbh->getConnection();
            $pageObJ = new Page($this->dbc);
            $pageObJ->findBy('id',$this->entityId);
            $variable['pageObj'] = $pageObJ;
            $template = new Template('main');
            $template->view('page/views/static', $variable);
            return false;
        }
        return true;
    }

    function defaultAction(){
        // $variable['tiltle'] = 'Contants Here';
        // $variable['content'] = 'please send us your mesage';

        // $dbh = DatabaseConnection::getInstance();
        // $dbc = $dbh->getConnection();

        
        $pageObJ = new Page($this->dbc);
        $pageObJ->findBy('id',$this->entityId);
        $variable['pageObj'] = $pageObJ;


        
        $this->template->view('contact/views/contact-us',$variable);
    }

    function submitContactFormAction(){
     
        // $dbh = DatabaseConnection::getInstance();
        // $dbc = $dbh->getConnection();

        
        $pageObJ = new Page($this->dbc);
        $pageObJ->findBy('id',$this->entityId);
        $variable['pageObj'] = $pageObJ;
        $_SESSION['has_sunmited_the_form'] = 1;

          
          $this->template->view('page/views/static', $variable);
    }

    // runging actiom

    
}

