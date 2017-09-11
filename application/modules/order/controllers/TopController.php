<?php
header('Expires: -1');

header('Cache-Control:');

header('Pragma:');

// NOTICEエラーの非表示

error_reporting(E_ALL ^ E_NOTICE);

/** AppController Must Be Include **/
require_once SYSTEM_DIR . '/modules/common/AppController.php';
require_once SYSTEM_DIR . '/modules/order/models/CafeOrderModel.php';

class Order_TopController extends AppController

{
	public function preDispatch()
	{
		// モデルのインスタンスを生成する
		
		$this->_dbconn = new CafeOrderModel($this->_config->kaigidatasource->kaigi->toArray());
	}
	
    public function indexAction()

    {
    	$this->_view->title = "Demo List";
    	
        $this->getResponse()->setBody($this->_view->renderForLayout('ins.phtml', 'listlayout.phtml'));
    }
    
    public function getorgsAction()
    {
    	$request = $this->getRequest();
    	$results = array();
    	
    	if($request->isPost()){
    		$paramerters = $request->getPost();
    		
    		/** Database1  **/
    		$orgArrays = $this->_dbconn->getOrgsArray($paramerters["key"], $paramerters["limit"], $paramerters["offset"], $paramerters["sortdatafield"], $paramerters["sortorder"]);
    		
    		array_push($results, array("rows" => $orgArrays, "count" => $this->_dbconn->getOrgsCount($paramerters["key"])));
    		
    		echo Zend_Json::encode($results[0]);
    	}
    }
}