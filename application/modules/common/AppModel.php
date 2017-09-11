<?php

// コンポーネントをロードする
require_once 'Zend/Db.php';

class AppModel
{
	private $_db; // データベースアダプタのハンドル
	
	/**
	 * コンストラクタ
	 *
	 */
	public function __construct($ysgear)
	{
		global $_db;
		
		// 接続情報を取得する
		if (!isset($ysgear) || count($ysgear) < 1) {
			throw new Zend_Exception(__FILE__ . '(' . __LINE__ . '): ' . 'データベース接続情報が取得できませんでした。');
		}
		
		// データベースに接続する
		if (is_null($_db)) {
			
			// データベースの接続パラメータを定義する
			$params = array(	'host'     => $ysgear['host'],
					'username' => $ysgear['user'],
					'port'     => $ysgear['port'],
					'charset'  => 'UTF8',
					'password' => $ysgear['password'],
					'dbname'   => $ysgear['dbname']
			);
			
			try {
				// データベースアダプタを作成する
				$_db = Zend_Db::factory($ysgear['type'], $params);
				
				// データ取得形式を設定する
				$_db->setFetchMode(Zend_Db::FETCH_ASSOC);
				
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(__FILE__ . '(' . __LINE__ . '): ' . $e->getMessage());
			}
		}
		$this->_db = $_db;
	}
	
	public function getDb(){
		return $this->_db;
	}
}