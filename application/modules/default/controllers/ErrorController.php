<?php

/**
 * エラーコントローラ
 *
 * @copyright 2011 Liquid Vision Co., Ltd.
 * @version   1.0.0
 * @since     File available since Release 1.0.0
 */


// コンポーネントをロードする
require_once 'Zend/Controller/Action.php';
require_once 'Zend/Registry.php';
require_once 'Zend/Session.php';
require_once 'Zend/Log.php';
require_once 'Zend/Log/Writer/Stream.php';
require_once 'Zend/View.php';

// ライブラリをロードする
//require_once SYSTEM_DIR . '/lib/multilingual.php';

class ErrorController extends Zend_Controller_Action
{

    private $_sessName; // セッション名
    private $_config;   // システム設定情報
    private $_view;     // Zend_Viewのインスタンス


    /**
     * 初期化処理
     *
     */
    public function init()
    {
        // メイン設定情報をロードする
        $this->_config = Zend_Registry::get('config');


        // セッション名を設定する
        $this->_sessName = 'global.' . $this->_config->global->version . '.' . $this->getRequest()->getModuleName();

        // Zend_Viewを初期化する
        $this->_view = new Zend_View();
        $this->_view->setScriptPath(PUBLIC_DIR . $this->_config->global->basePath . '/');
        $this->_view->setEncoding('UTF-8');
    }

 /**
     * errorアクション
     */
    public function errorAction()
    {
    	// 直アクセスの場合は何もしない
    	if (strpos(strtolower($this->getRequest()->getRequestUri()), 'error/error') !== false) {
    		return;
    	}

    	// デバッグフラグを設定する
    	$debugFlg = ($this->_config->global->execMode == 'debug') ? true : false;

    	// レスポンスオブジェクトを取得する
    	$response = $this->getResponse();


    	// エラーハンドラを取得する
        $errors = $this->_getParam('error_handler');

        // エラーの種別ごとにメッセージを表示する
        switch ($errors->type) {

        	// コントローラが見つからない場合
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

                // 404 error -- controller or action not found
                $this->_forward('code404');
                break;

            // その他のエラーの場合
            default:



                // メッセージがセットされていればそれを表示する
                $exception = (isset($errors->exception)) ? $errors->exception : null;
                if ($exception !== null) {

                    // エラーメッセージをログファイルへ記録する
                    if ($this->_config->global->outErrorLog == '1') {

                        if (!is_writeable(SYSTEM_DIR . '/log')) {
                            exit('「' . SYSTEM_DIR . '/log' . '」ディレクトリに書き込み権限を設定してください。');
                        } else if (file_exists(SYSTEM_DIR . '/log/error.log') && !is_writeable(SYSTEM_DIR . '/log/error.log')) {
                            exit('「' . SYSTEM_DIR . '/log/error.log' . '」ファイルに書き込み権限を設定してください。');
                        }

                        $logger = new Zend_Log();
                        $format = new Zend_Log_Formatter_Simple();
                        $writer = new Zend_Log_Writer_Stream(SYSTEM_DIR . '/log/error.log');
                        $writer->setFormatter($format);
                        $logger->addWriter($writer);
                        $logger->log(str_replace('): !!', '): ', $exception->getMessage()), Zend_Log::ERR);
                    }




                    // デバッグモードなら詳細メッセージをセットする
                    if ($debugFlg) {
                        if (strpos($exception->getMessage(), '): !!') !== false) {
                            $wk = explode('): !!', $exception->getMessage());
//                            $message = $wk[0] . '): ' . $wk[1];
                            $message = 'システムエラー4が発生しました。';
                        } else {
                            $message = $exception->getMessage();
                        }

                    // リリースモードなら固定メッセージをセットする
                    } else {
                        if (strpos($exception->getMessage(), '): !!') !== false) {
                            $wk = explode('): !!', $exception->getMessage());
                            $message = $wk[1];
                        } else {
                            $message = 'システムエラーが発生しました。';
                        }
                    }

                // メッセージがセットされていなければ固定メッセージを表示する
                } else {
                    $message = 'システムエラーが発生しました。';
                }


                $tplVars = array('basePath' => $this->_config->global->basePath,
                                 'message'  => $message
                           );

                $this->_view->assign($tplVars);

                $response->setBody($this->_view->render('error/error.html'));

                break;
        }

    }


    /**
     * code404アクション
     */
    public function code404Action()
    {
        // レスポンスオブジェクトを取得する
        $response = $this->getResponse();

        // 404コードを出力する
        $response->setRawHeader('HTTP/1.1 404 Not Found');

        // テンプレートに値をセットする
        $tplVars = array(
                         'basePath' => $this->_config->global->basePath
                   );

        $this->_view->assign($tplVars);

        // テンプレートをレンダリングする
        $response->setBody($this->_view->render('error/404.html'));
    }

}

