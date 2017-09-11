<?php

require_once 'Zend/View.php';

class App_View extends Zend_View
{
	public $module = "";
	
	public $controller= "";
	
	public function renderForLayout($name = "", $layout = "")
	{
		if(empty($key) && empty($layout)){
			
			throw new Zend_Exception('Render Target Html Must To Be Set.');
			
		} else if(isset($name) && empty($layout)){
			
			return $this->render($name);
			
		} else {
			$content = array('content'=> $this->render($name));
			
			$this->assign($content);
			
			return $this->render($layout);
		}
	}
}