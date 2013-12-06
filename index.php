<?php
define('DS',         DIRECTORY_SEPARATOR);
define('DIR_BASE',   realpath(dirname(__FILE__)) . DS);
define('DIR_GLOBAL', DIR_BASE . 'global' . DS);
define('DIR_LIBS',   DIR_GLOBAL . 'libs' . DS);
define('DIR_APPS',   DIR_BASE . 'apps' . DS);

/* Configurations
-------------------------------*/
$config = array();
$config['app'] = 'main';

$config['controllers'] = 'controllers';
$config['environment'] = 'production';
$config['models']      = 'models';
$config['theme']       = 'default';
$config['themes']      = 'themes';

define('DIR_APP', DIR_APPS . $config['app'] . DS);

require DIR_APP . 'config_prepend.php';

define('DIR_THEMES', DIR_APP . $config['themes'] . DS);
define('DIR_CONTROLLERS', DIR_APP . $config['controllers'] . DS);
define('DIR_MODELS', DIR_APP . $config['models'] . DS);
define('DIR_THEME', DIR_THEMES . $config['theme'] . DS);
define('ENVIRONMENT', $config['environment']);

switch (ENVIRONMENT) {
	case 'development':
		error_reporting(E_ALL);
		ini_set('display_errors', 'On');
		break;
	
	default:
		error_reporting(0);
		ini_set('display_errors', 'Off');
		break;
}

require DIR_LIBS . 'burg.php';
require DIR_APP . 'config_append.php';

burg('router');