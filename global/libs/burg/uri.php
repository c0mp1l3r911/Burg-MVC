<?php

class Burg_URI {
	private $_URL;
	private $_parse;
	private $_key;

	public function __construct() {
		$this->_URL = $this->current();
		
		return $this->_parseURL();
	}

	public function current() {
		$page_url = 'http';
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) 
			$page_url .= 's';

		$page_url .= '://';
		if ($_SERVER['SERVER_PORT'] != 80) 
			$page_url .= $_SERVER['SERVER_NAME'] . ':' 
					  . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
		else
			$page_url .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

		return $page_url;
	}

	private function _parseURL($key = false) {
		$pieces = parse_url($this->_URL);
		if ($key) 
			if (isset($pieces[$key]) && !empty($pieces[$key])) 
				return $pieces[$key];
			else
				return false;

		$this->_parse = $pieces;
		return $this;
	}

	public function setUrl($url = false) {
		if ($url) 
			$this->_URL = $url;

		return $this->_parseURL();
	}

	public function find($key) {
		if (is_string($key)) 
			$this->_key = $key;
		return $this;
	}

	public function segments() {
		$path = $this->find('path')->getResult();
		$segments = array();
		if ($path) {
			$segments = explode('/', $path);
			$segments = array_filter($segments);
			$segments = array_values($segments);
		}

		return $segments;
	}

	public function segment($index) {
		$index = ((int) $index) - 1;
		$segments = $this->segments();
		if (isset($segments[$index]))
			return $segments[$index];
		return false;
	}

	public function getResult() {
		if ($this->_key) 
			if (isset($this->_parse[$this->_key])) 
				return $this->_parse[$this->_key];
			else
				return false;

		return $this->_parse;
	}
}