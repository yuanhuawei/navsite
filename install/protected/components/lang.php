<?php 

class lang
{
static function getLang($k=null){
return array(
            '777_test' => "<font color='red'> 777属性检测不通过</font>",
            'no_file' => "<font class=c1>文件不存且无权限建立,请设置目录写权限或手动上传此文件</font>",
            'test_ok' => "<font color='#00CC00'> 可写<b>√</b></font>",
            'no_write' => "目录无法书写,请速将根目录属性设置为777",
            'no_database' => "指定的数据库不存在,且您无权限建立,请联系服务器管理员!",
            'donot_insert' =>"数据表写入数据失败,请检查数据表设置及账号权限!",
            'low_version' => "很抱歉，您的php版本太低，请升级至5.1.0以上版本。",
            'del_install' => "请记住用FTP删除 install.php 安装文件!",
            'creat_table' => "建立数据表 ",
            'success' => "完成",
            'no_same_adminpw' => "两次管理员密码不同",
            'no_empty_database' => "数据库中已有同名数据表,请修改本程序数据表前缀",
            'no_do_database' => "操作数据库失败",
        );
}

static function viewCheck()
{
return array(
                array(
                    t('yii', 'PHP版本'),
                    true,
                    version_compare(PHP_VERSION, "5.1.0", ">="),
                    '<a href="http://www.yiiframework.com">Yii Framework</a>',
                    t('yii', 'PHP 5.1.0或更高版本是必须的。')),
                array(
                    t('yii', '$_SERVER变量'),
                    true,
                    '' === $message = checkServerVar(),
                    '<a href="http://www.yiiframework.com">Yii Framework</a>',
                    $message),
                array(
                    t('yii', 'Reflection扩展模块'),
                    true,
                    class_exists('Reflection', false),
                    '<a href="http://www.yiiframework.com">Yii Framework</a>',
                    ''),
                array(
                    t('yii', 'PCRE扩展模块'),
                    true,
                    extension_loaded("pcre"),
                    '<a href="http://www.yiiframework.com">Yii Framework</a>',
                    ''),
                array(
                    t('yii', 'SPL扩展模块'),
                    false,
                    extension_loaded("SPL"),
                    '<a href="http://www.yiiframework.com">Yii Framework</a>',
                    ''),
                array(
                    t('yii', 'DOM扩展模块'),
                    false,
                    class_exists("DOMDocument", false),
                    '<a href="http://www.yiiframework.com/doc/api/CHtmlPurifier">CHtmlPurifier</a>, <a href="http://www.yiiframework.com/doc/api/CWsdlGenerator">CWsdlGenerator</a>',
                    ''),
                array(
                    t('yii', 'PDO扩展模块'),
                    true,
                    extension_loaded('pdo'),
                    t('yii', '所有和<a href="http://www.yiiframework.com/doc/api/#system.db">数据库相关的类</a>'),
                    ''),
                
                array(
                    t('yii', 'PDO MySQL扩展模块'),
                    true,
                    extension_loaded('pdo_mysql'),
                    t('yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
                    t('yii', '如果使用MySQL数据库，这是必须的。')),

                array(
                    t('yii', 'GD extension with<br />FreeType support<br />or ImageMagick<br />extension with<br />PNG support'),
                    false,
                    '' === $message = checkCaptchaSupport(),
                    '<a href="http://www.yiiframework.com/doc/api/CCaptchaAction">CCaptchaAction</a>',
                    $message),
                array(
                    t('yii', 'Ctype extension'),
                    false,
                    extension_loaded("ctype"),
                    '<a href="http://www.yiiframework.com/doc/api/CDateFormatter">CDateFormatter</a>, <a href="http://www.yiiframework.com/doc/api/CDateFormatter">CDateTimeParser</a>, <a href="http://www.yiiframework.com/doc/api/CTextHighlighter">CTextHighlighter</a>, <a href="http://www.yiiframework.com/doc/api/CHtmlPurifier">CHtmlPurifier</a>',
                    ''
                ),
            );
}

		}
		?>