<?php


//システムディレクトリを設定する
define('SYSTEM_DIR', realpath('../application/'));


// 公開ディレクトリを設定する
define('PUBLIC_DIR', realpath('./'));

// データベースオブジェクト格納用
$_db = null;

//コンポーネントをロードする
require_once 'Zend/Controller/Front.php';
require_once 'Zend/Session.php';
require_once 'Zend/Registry.php';
require_once 'Zend/Config/Ini.php';
require_once 'Zend/Controller/Plugin/ErrorHandler.php';

// セッションをスタートする
Zend_Session::start();



// 設定情報をロードする
$config = new Zend_Config_Ini(SYSTEM_DIR . '/lib/config.ini', null);
// 設定情報をレジストリに登録する
Zend_Registry::set('config', $config);



//フロントコントローラのインスタンスを取得する
$front = Zend_Controller_Front::getInstance();



//コントローラのディレクトリを設定する(モジュール構成の場合は不要）
//$front->setControllerDirectory('../application/controllers');

//モジュールのディレクトリを設定する
$front->addModuleDirectory(SYSTEM_DIR . '/modules');

//自動レンダリングモードを無効にする
$front->setParam('noViewRenderer', true);

//ディスパッチする
$front -> dispatch();

