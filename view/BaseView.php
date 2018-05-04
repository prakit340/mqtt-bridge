<?php

class BaseView {
	protected $errors = array();
	protected $warnings = array();
	protected $info = array();
	protected $values = array();
	protected $layout = 'default';
	protected $title = 'base';

	public function setError($text) {
		array_push($this->errors,$text);
	}

	public function setWarning($text) {
		array_push($this->warnings,$text);
	}

	public function getErrors() {
		return '<div class="error">'.join('<br>',$this->errors).'</div>';
	}

	public function setValue($name,$value) {
		$this->values[$name] = $value;
	}

	public function setInfo($text) {
		array_push($this->info,$text);
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getWarnings() {
		return '<div class="warning">'.join('<br>',$this->warnings).'</div>';
	}

	public function getInfo() {
		return '<div class="info">'.join('<br>',$this->info).'</div>';
	}

	public function getValue($name) {
		if (isset($this->values[$name])) {
			return $this->values[$name];
		}
	}

	public function setLayout($name) {
		$this->layout = $name;
	}

	public function render() {
		if (file_exists('templates/layout/'.$this->layout.'.html')) {
			$layout = file_get_contents('templates/layout/'.$this->layout.'.html');
		}
		$view = '';
		if (file_exists('templates/view/'.get_class($this)).'.php') {
			ob_start();
			include 'templates/view/'.get_class($this).'.php';
			$view = ob_end_flush();
		}

		$layout = str_replace('{VIEW}',$view,$layout);
		$layout = str_replace('{TITLE}',$this->title,$layout);

		print_r($layout);
	}
}
