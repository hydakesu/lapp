<?php
// コンポーネントをロードする

require_once 'Zend/Controller/Action.php';

//require_once 'Zend/View.php';
require_once SYSTEM_DIR . '/modules/common/AppView.php';

require_once 'Zend/Date.php';

require_once 'Zend/Json.php';

class AppController extends Zend_Controller_Action

{
	
	protected $_config;     // システム設定情報
	
	protected $_view;       // Zend_Viewのインスタンス
	
	protected $_dbconn;     // DB接続のインスタンス
	
	/**
	
	* 初期化処理
	
	*
	
	*/
	
	public function init()
	
	{
		
		// メイン設定情報をロードする
		
		$this->_config = Zend_Registry::get('config');
		
		// Zend_Viewを初期化する
		
		// インスタンスを生成する
		
		$this->_view = new App_View();
		
		// ビュースクリプトのディレクトリを設定する
		
		$this->_view->setScriptPath(PUBLIC_DIR . '/' . $this->getRequest()->getModuleName());
		
		$this->_view->module = $this->getRequest()->getModuleName();
		
		$this->_view->controller = $this->getRequest()->getControllerName();
		
		// ビュースクリプトのディレクトリを設定する
		
		$this->_view->addBasePath(PUBLIC_DIR . '/layouts');
		
		// 文字コードを設定する
		
		$this->_view->setEncoding('UTF-8');
		
	}
	
}