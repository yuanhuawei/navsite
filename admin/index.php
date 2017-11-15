<?php
error_reporting(E_ERROR);
ini_set('default_charset','GB2312');

//$http_host = $_SERVER['HTTP_HOST'];
$http_host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');

$http_host = str_replace('\\', '/', $http_host);
$dt_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$st_filename = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']);

$sst_filename = dirname(dirname($st_filename));

if (substr($http_host, -1) != '/') $http_host .= '/';
if (substr($dt_root, -1) != '/') $dt_root .= '/';
if (substr($sst_filename, -1) != '/') $sst_filename .= '/';

$siteUrl = str_replace(array($dt_root), array('http://' . $http_host), $sst_filename);
$siteBackendUrl = str_replace(array($dt_root, '/index.php'), array('http://' . $http_host, '/'), $st_filename);

defined('SITE_URL') or define('SITE_URL', $siteUrl); //http://xxxi.com/
//��վ�����̨��url
defined('SITE_BACKEND_URL') or define('SITE_BACKEND_URL', $siteBackendUrl); //http://xxxi.com/admin/
//�����̨·��
defined('SITE_BACKEND_PATH') or define('SITE_BACKEND_PATH', dirname(__FILE__) . '/'); // www/kyii/bd/ 
//��վ·��
defined('SITE_PATH') or define('SITE_PATH', dirname(SITE_BACKEND_PATH) . '/'); // www/kyii/

//���غ��ĺ�����
$yii=dirname(__FILE__).'/../core/yii.php';
$menu=dirname(__FILE__).'/protected/config/menu.php';
$main=dirname(__FILE__).'/protected/config/main.php';

defined('YII_DEBUG') or define('YII_DEBUG',false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
require_once($menu);

Yii::$classMap=array('CHtml'=>dirname(__FILE__).'/protected/extensions/helpers/CHtml.php');

Yii::createWebApplication($main)->run();
