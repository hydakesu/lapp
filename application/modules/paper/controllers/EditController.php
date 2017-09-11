<?php
header('Expires: -1');

header('Cache-Control:');

header('Pragma:');

// NOTICEエラーの非表示

error_reporting(E_ALL ^ E_NOTICE);

/** AppController Must Be Include **/
require_once SYSTEM_DIR . '/modules/common/AppController.php';
require_once SYSTEM_DIR . '/modules/paper/models/SampleModel.php';

class Paper_EditController extends AppController

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
		
		$this->getResponse()->setBody($this->_view->renderForLayout('edit.phtml', 'paper.phtml'));
	}
	
	public function saveAction(){
		$request = $this->getRequest();
		
		if($request->isPost()){
			$paramerters = $request->getPost();
			
			$this->_dbconn->getDb()->beginTransaction();
			try {
				if($paramerters["flg"] == "add"){
					$dbRresult = $this->_dbconn->saveDetail($paramerters);
				}else if($paramerters["flg"] == "del"){
					$dbRresult = $this->_dbconn->delDetail($paramerters);
				}else if($paramerters["flg"] == "edit"){
					$dbRresult = $this->_dbconn->updateDetail($paramerters);
				}
				
				$this->_dbconn->getDb()->commit();
			} catch (Zend_Exception $e) {
				$this->_dbconn->getDb()->rollback();
				
				throw new Zend_Exception(__FILE__ . '(' . __LINE__ . '): ' . $e->getMessage());
			}
			
			array_push($results, array("result" => "OK"));
			
			echo Zend_Json::encode($results[0]);
		}
	}
}