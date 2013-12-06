<?php

class BaseController {
	protected $smarty;
	protected $load;

	public function __construct() {
		$this->load = $this;
	}

	protected function model() {
		$prefix = 'model_';
		$args = func_get_args();
		if (!$args) 
			return false;
		$class_name = $args[0];
		unset($args[0]);
		$args = array_values($args);
		if ($args) 
			return burg_loader($class_name, DIR_MODELS, $prefix, $args);
		return burg_loader($class_name, DIR_MODELS, $prefix);
	}
}