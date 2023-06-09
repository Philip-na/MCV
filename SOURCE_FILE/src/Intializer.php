<?php
require_once ROOT_PATH . 'src/interfaces/ValidationRuleInterface.php';
require_once ROOT_PATH . 'src/controller.php';
require_once ROOT_PATH . 'src/entity.php';
require_once ROOT_PATH . 'src/template.php';
require_once ROOT_PATH . 'src/router.php';
require_once ROOT_PATH . 'src/Auth.php';
require_once ROOT_PATH . 'src/Validation.php';
require_once ROOT_PATH . 'src/validationRules/ValidateEmail.php';
require_once ROOT_PATH . 'src/validationRules/ValidateMaximum.php';
require_once ROOT_PATH . 'src/validationRules/ValidateMinimum.php';
require_once ROOT_PATH . 'src/validationRules/ValidateSpecialChar.php';
require_once ROOT_PATH . 'src/validationRules/ValidateNoEmptySpaces.php';
require_once ROOT_PATH . 'src/databaseConnection.php';
require_once MODULE_PATH . 'page/models/page.php';
require_once MODULE_PATH . 'user/models/User.php';

DatabaseConnection::connect('localhost','mcv_db','root','');