<?php
!defined('SITE_URL') && exit('Forbidden'); //��index.php����
include_once 'db.php';

$info['db_user'] = $GLOBALS ['database'] ['db_user']; 
$info['db_pass'] = $GLOBALS ['database'] ['db_pass']; 
$info['db_name'] = $GLOBALS ['database'] ['db_name']; 
$info['db_charset'] = $GLOBALS ['database'] ['db_charset']; 
$info['table_prefix'] = $GLOBALS ['database'] ['table_prefix']; 
$info['db_host'] = $GLOBALS ['database'] ['db_host']; 

//!defined('ADMINUSER') && define('ADMINUSER', $GLOBALS ['database'] ['manager']); //����Ա�˻�
//!defined('ADMINPW') && define('ADMINPW', $GLOBALS ['database'] ['managerpw']); //����Ա����

unset($GLOBALS ['database']);

//��վ����
!defined('QZ_URL') && define('QZ_URL', 'http://q.115.com/347/'); 

// �汾��
!defined('SYS_VERSION') && define('SYS_VERSION', '2.0'); 

// ����ʱ��
!defined('SYS_UPTIME') && define('SYS_UPTIME', '2014.08.08'); 

//����JS img updĿ¼url
!defined('COMMON_JS_URL') && define('COMMON_JS_URL', SITE_URL . 'static/js/');
!defined('COMMON_IMG_URL') && define('COMMON_IMG_URL', SITE_URL . 'static/images/');

// �ϴ�Ŀ¼
!defined('DIR_UPLOADS') && define('DIR_UPLOADS', SITE_PATH.'static/uploads/'); 

// �ϴ�Ŀ¼url
!defined('DIR_UPLOADS_URL') && define('DIR_UPLOADS_URL', SITE_URL.'static/uploads/'); 

//��̨static��url
!defined('STATIC_BACKEND_URL') && define('STATIC_BACKEND_URL', SITE_BACKEND_URL . 'static/');

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => '114����Դ����',
    'language' => 'zh_cn', //����framework\messages\zh_cn\yii.php �ļ����뺺��
//    'theme' => 'default', //Ĭ������
    'charset'=>'gb2312',  //������վ�ַ�����  
    'defaultController' => 'default', //���÷�moduleĬ�Ͽ�������
    'timeZone' => 'Asia/Shanghai',
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '1230',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
//    'preload' => array('log'), //��־��¼
    'components' => array(
        'coreMessages'=>array(  
            'basePath'=>'protected/messages',  
        ),
        'request' => array(
            'enableCsrfValidation' => true,
            'enableCookieValidation'=>true,
        ),
        'cache' => array(
            'class' => 'CFileCache',
        ),
        'localeDataPath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../i18n/data',
        'db' => array(
            'connectionString' => 'mysql:host='.$info['db_host'].';dbname='.$info['db_name'],
            'emulatePrepare' => true,
            'enableParamLogging' => true, //��ҳ��ײ���sql����ʾ�󶨵Ĳ���
            'enableProfiling' => true,
            'username' => $info['db_user'],
            'password' => $info['db_pass'],
            'charset' => $info['db_charset'],
            'tablePrefix' => $info['table_prefix'],
        ),
        'errorHandler' => array(
            'errorAction' => 'error/index',
        ),
        /*����debug׷��
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                array(
                    'class' => 'CWebLogRoute',
                ),
            ),
        ), */
        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
            'loginUrl' => array('site/login'),
        ),
        'urlManager' => array(
//            'urlFormat' => 'path',
//            'urlSuffix' => '.html',
//            'showScriptName' => FALSE, //false,//���������index.php,����Ҫ��α��̬���� 
            'rules' => array(
                // post/show&id=xx
                'post/<id:\d+>/*' => 'post/show',
                // post/show&id=xx
                'post/<id:\d+>_<title:\w+>/*' => 'post/show',
                'post/catalog/<catalog:[\w-_]+>/*' => 'post/index',
                'page/show/<name:\w+>/*' => 'page/show',
                'special/show/<name:[\w-_]+>/*' => 'special/show',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'wusong@ylmf.com',
    ),
);