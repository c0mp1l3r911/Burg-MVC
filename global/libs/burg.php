<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('DIR_LIBS') or define('DIR_LIBS', dirname(__FILE__) . DS);
define('DIR_BURG', dirname(__FILE__) . DS . 'Burg' . DS);

function burg() {
	$args = func_get_args();
	if (!$args) 
		return false;

	$prefix = __FUNCTION__ . '_';
	$class_name = preg_replace('/[^a-z0-9_]/', '', strtolower($args[0]));
	unset($args[0]);
	$args = array_values($args);

	if (strpos($class_name, $prefix) === 0) 
		$file = DIR_LIBS . str_replace('_', DS, $class_name) . '.php';
	else if (strpos($class_name, '_') === 0)
		$file = DIR_BURG . str_replace('_', DS, $class_name) . '.php';
	else
		$file = DIR_BURG . $class_name . '.php';

	if (!file_exists($file)) 
		return false;

	include_once $file;
	if (class_exists($class_name)) {
		if ($args) {
			$class = new reflectionClass($class_name);
			return $class->newInstanceArgs($args);
		}

		return new $class_name;
	} else if (class_exists($prefix . $class_name)) {
		$class_name = $prefix . $class_name;
		if ($args) {
			$class = new reflectionClass($class_name);
			return $class->newInstanceArgs($args);
		}

		return new $class_name;
	}

	return false;
}

function burg_autoload() {
	$args = func_get_args();
	$class_name = $args[0];

	$class_name = preg_replace('/[^a-z0-9_]/', '', strtolower($class_name));
	// Smarty uses its own autoloader, so we exclude all Smarty classes
	if (strpos($class_name, 'smarty_') === 0)
		return;

	$search_dirs = array(DIR_LIBS, DIR_CONTROLLERS, DIR_MODELS);
	if (isset($args[1]) && is_array($args[1]) && !empty($args[1])) 
		$search_dirs = $args[1];

	foreach ($search_dirs as $dir) {
		$file = $dir . str_replace('_', DS, $class_name) . '.php';
		if (file_exists($file)) {
			include_once $file;
			return;
		}

		if (strpos($class_name, '_') === 0) {
			$path_pieces = explode('_', $class_name);
			$pieces_count = count($path_pieces);

			for ($i = 1; $i < $pieces_count; $i++) { 
				$file = $dir . implode(DS, array_slice($path_pieces, 0, $i)) . DS . implode('_', array_slice($path_pieces, $i)). '.php';
				if (file_exists($file)) {
					include_once $file;
					return;
				}
			}
		}
	}
}

function burg_loader($class_name, $dir, $prefix = '', $args = array()) {
	$class_name = preg_replace('/[^a-z0-9_]/', '', strtolower($class_name));

	if (strpos($class_name, '_') === 0)
		$file = $dir . str_replace('_', DS, $class_name) . '.php';
	else
		$file = $dir . $class_name . '.php';

	if (!file_exists($file)) 
		return false;
	
	include_once $file;

	if (!class_exists($prefix . $class_name)) 
		return false;

	$class_name = $prefix . $class_name;

	if ($args) {
		$class = new reflectionClass($class_name);
		return $class->newInstanceArgs($args);
	}

	return new $class_name;
}

spl_autoload_register('burg_autoload');

// requiring Smarty Templating Library
require DIR_LIBS . 'Smarty.php';

