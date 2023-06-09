<?php
class PageController extends Controller{
    function defaultAction(){

        // $variable['tiltle'] = 'About us page';
        // $variable['content'] = 'get to now more about us';

        // $dbh = DatabaseConnection::getInstance();
        // $dbc = $dbh->getConnection();

        
        $pageObJ = new Page($this->dbc);
        $pageObJ->findBy('id',$this->entityId);
        $variable['pageObj'] = $pageObJ;


        
        $this->template->view('page/views/static',$variable);
    }
}


