<?php
session_start();

define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR .'..' . DIRECTORY_SEPARATOR);
define('VIEW_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'veiw' . DIRECTORY_SEPARATOR);
define('MODULE_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR);


require_once ROOT_PATH . 'src/controller.php';
require_once ROOT_PATH . 'src/entity.php';
require_once ROOT_PATH . 'src/template.php';
require_once ROOT_PATH . 'src/router.php';
require_once ROOT_PATH . 'src/databaseConnection.php';
require_once MODULE_PATH . 'page/models/page.php';


DatabaseConnection::connect('localhost','mcv_db','root',''); 

$sectionTo = $_GET['seo_name'] ?? $_POST['seo_name'] ?? 'home'; 

$dbh = DatabaseConnection::getInstance();
$dbc = $dbh->getConnection();

$router = new Router($dbc);
$router->findBy('pretty_url',$sectionTo);
// var_dump($router);

$action = ($router->action ?? '') != '' ? $router->action : 'default';
$moduleName = $router->module . 'Controller';
//  var_dump($moduleName);
$controllerFile = MODULE_PATH . $router->module . '/controllers/' . $moduleName . '.php';

if(file_exists($controllerFile)){
    // echo "preached <hr>";
    include $controllerFile;

    $controller = new $moduleName();
    $controller->dbc = $dbc;
    $controller->template = new Template('/layout/main');
    $controller->setEntityId($router->entity_id);
    $controller->runAction($action);
}





