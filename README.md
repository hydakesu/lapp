#PHP学习练手用

##必要的软件
1. ZendFramework-1.12.11
1. httpd-2.4.25-x64-vc11-r1
1. php-5.6.30-Win32-VC11-x64
1. php_xdebug-2.5.4-5.6-vc11-x86\_64
1. vcredist_x64.exe

##必要的配置
###Apache
- Define SRVROOT "/Apache24"                                   ←	①Apache24中のインストール場所を設定
- #LoadModule rewrite_module modules/mod_rewrite.so            ←	コメントアウトする
- AllowOverride none                                           ←	AllowOverride All
- DirectoryIndex index.html                                    ←	DirectoryIndex index.php index.html
- LoadModule php5_module "D:/LAPP/php/php5apache2_4.dll"       ←    追加
- AddHandler application/x-httpd-php .php                      ←	    追加
- AddType application/x-compress .Z                            ←	    追加
- AddType application/x-gzip .gz .tgz                          ←	    追加
- Addtype application/x-httpd-php .php .phtml                  ←	    追加
- Addtype application/x-httpd-php-source .phps                 ←	    追加
- PHPIniDir "D:/LAPP/php                                       ←    追加

###Php
- ;extension=php_fileinfo.dll                                           ←	コメントアウトする
- ;extension=php_pdo_pgsql.dll                                          ←	コメントアウトする
- ;extension=php_pgsql.dll                                              ←	コメントアウトする
- ;date.timezone =                                                      ←	date.timezone ="PRC"
- zend_extension=D:/LAPP/php/ext/php_xdebug-2.5.4-5.6-vc11-x86_64.dll   ←	追加
- [Xdebug]                                                              ←	追加
- xdebug.auto_trace = On                                                ←	追加
- xdebug.show_exception_trace = On                                      ←	追加
- xdebug.remote_autostart = On                                          ←	追加
- xdebug.remote_enable = 1                                              ←	追加
- xdebug.collect_vars = On                                              ←	追加
- xdebug.collect_return = On                                            ←	追加
- xdebug.collect_params = On                                            ←	追加
- xdebug.trace_output_dir=D:/LAPP/xDebugLog                             ←	追加
- xdebug.profiler_output_dir=D:/LAPP/xDebugLog                          ←	追加
- xdebug.profiler_enable=On                                             ←	追加
- xdebug.remote_host=localhost                                          ←	追加
- xdebug.remote_port=9000                                               ←	追加
- xdebug.remote_handler=dbgp                                            ←	追加

###PhpDebug
- 使用php_xdebug配置，百度一下就好