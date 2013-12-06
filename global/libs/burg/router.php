<?php

class Burg_Router {
	private $_class;
	private $_controller = 'welcome';
	private $_method = 'index';
	public function __construct() {
		global $config;

		if (isset($config['default_controller']))
			$this->_controller = $this->_setController($config['default_controller']);

		if (isset($config['default_method']))
			$this->_method = $this->_setMethod($config['default_method']);

		$this->_init();
	}

	private function _setController($controller_name) {
		$this->_controller = preg_replace('/[^a-z0-9_]/', '', strtolower($controller_name));
	}

	private function _setMethod($method_name) {
		$this->_method = preg_replace('/[^a-z0-9_]/', '', strtolower($method_name));
	}

	private function _init() {
		$URI = burg('uri');
		if ($URI->segment(1)) 
			$this->_setController($URI->segment(1));

		if ($URI->segment(2)) 
			$this->_setMethod($URI->segment(2));

		$file = DIR_CONTROLLERS . $this->_controller . '.php';

		if (!file_exists($file)) 
			$this->_error404();
		else
			include_once $file;

		if (!class_exists($this->_controller)) 
			$this->_error404();

		$class = new $this->_controller;
		if (!method_exists($class, $this->_method)) 
			$this->_error404();

		if (!is_callable(array($class, $this->_method), true, $callable_name)) 
			$this->_error404();

		$class->{$this->_method}();
	}

	private function _error404() {
		require_once DIR_CONTROLLERS . 'error.php';

		$this->_setController('error');
		$this->_setMethod('not_found');
	}
}