<?php
//��վurl
$siteUrl = str_replace(array($_SERVER['DOCUMENT_ROOT']), array('http://'.$_SERVER['HTTP_HOST']), dirname(dirname($_SERVER['SCRIPT_FILENAME'])));
defined('SITE_URL') or define('SITE_URL',$siteUrl.'/'); //http://xxxi.com/

//��վ�����̨��url
$siteBackendUrl = str_replace(array($_SERVER['DOCUMENT_ROOT'],'/index.php'), array('http://'.$_SERVER['HTTP_HOST'],'/'), $_SERVER['SCRIPT_FILENAME']);
defined('SITE_BACKEND_URL') or define('SITE_BACKEND_URL',$siteBackendUrl); //http://xxxi.com/backend/

//�����̨·��
defined('SITE_BACKEND_PATH') or define('SITE_BACKEND_PATH', dirname(__FILE__).'/'); // www/kyii/bd/ 

//��վ·��
defined('SITE_PATH') or define('SITE_PATH', dirname(SITE_BACKEND_PATH).'/'); // www/kyii/

//���غ��ĺ�����
$yii=dirname(__FILE__).'/../core/yii.php';
$menu=dirname(__FILE__).'/protected/config/menu.php';
$main=dirname(__FILE__).'/protected/config/main.php';

defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
require_once($menu);

$_GET['r'] = 'crond';

Yii::createWebApplication($main)->run();


