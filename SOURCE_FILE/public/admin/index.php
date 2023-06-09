<?php
session_start();
define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR .'..' . DIRECTORY_SEPARATOR .'..' . DIRECTORY_SEPARATOR);
define('VIEW_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'veiw' . DIRECTORY_SEPARATOR);
define('MODULE_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR);

require_once ROOT_PATH . 'src/Intializer.php';


$section = $_GET['seo_name'] ?? 'home';
$dbh = DatabaseConnection::getInstance();
$dbc = $dbh->getConnection();
$section = $_GET['module'] ?? $_POST['module'] ?? 'dashboard';
$action = $_GET['action'] ?? $_POST['action'] ?? 'default';

if ($section=='dashboard') {
    
    include MODULE_PATH . 'dashboard/admin/controllers/DashboardController.php';    
    $dashboardController = new DashboardController();
    $dashboardController->dbc = $dbc;
    $dashboardController->template = new Template('admin/layout/defualt');
    $dashboardController->runAction($action);
}elseif($section == 'page'){
    include MODULE_PATH . 'Page/admin/controllers/PageController.php';
    $pageController = new PageController();
    $pageController->dbc = $dbc;
    $pageController->template = new Template('admin/layout/defualt');
    $pageController->runAction($action);
    
}




