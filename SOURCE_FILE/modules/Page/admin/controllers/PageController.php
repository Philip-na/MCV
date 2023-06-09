<?php
class PageController extends Controller{


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
       
        $variables = [];
        $pageHandler = new page($this->dbc);

        $pages = $pageHandler->findAll();
        // var_dump($pages);
        $variables['pages'] = $pages;
        $this->template->view('page/admin/views/page-list',$variables);
    }

    function editPageAction(){  
        $pageId = $_GET['id'];

        $page = new page($this->dbc);
        $page->findBy('id',$pageId);

        if($_POST['editComferm'] ?? false ){
          $page->setValues($_POST);
          $page->save();
        }

        
        // var_dump($page);
        $variable['pageObj'] = $page;
        $this->template->view('page/admin/views/page-edit',$variable);
    }
}