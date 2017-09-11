<?php
header('Expires: -1');

header('Cache-Control:');

header('Pragma:');

// NOTICEエラーの非表示

error_reporting(E_ALL ^ E_NOTICE);

/** AppController Must Be Include **/
require_once SYSTEM_DIR . '/modules/common/AppController.php';
require_once SYSTEM_DIR . '/modules/paper/models/SampleModel.php';

class Paper_ViewController extends AppController

{

	public function preDispatch()
	{
		// モデルのインスタンスを生成する
		$this->_dbconn = new SampleModel($this->_config->datasource->database->toArray());
	}
	
	public function indexAction()
	
	{
		$this->_view->title = "Demo List";
		
		$result = $this->_dbconn->getDetail("lapp");
		
		$result = array('details' => $this->_dbconn->getDetail("lapp"));
		
		$this->_view->assign($result);
		
		$this->getResponse()->setBody($this->_view->renderForLayout('view.phtml', 'paper.phtml'));
	}
}