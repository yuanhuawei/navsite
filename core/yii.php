<?php
/**
 * Yii bootstrap file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @package system
 * @since 1.0
 */

require(dirname(__FILE__).'/YiiBase.php');

/**
 * Yii is a helper class serving common framework functionalities.
 *
 * It encapsulates {@link YiiBase} which provides the actual implementation.
 * By writing your own Yii class, you can customize some functionalities of YiiBase.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system
 * @since 1.0
 */
class Yii extends YiiBase
{
    /*以下是自定义静态类,前缀加上my,驼峰式,  wusong 20130828*/
    
    /**
     * 简单的输出调试
     * @param unknown_type $date
     */
    static function myPpr($date,$type=null) 
    {
        $typeShow = null;
        if ($type == 'h') //hidden
        {
            $typeShow = "style='display:none;'";
        }
        
        echo '<div '.$typeShow.'><pre>';
        print_r($date);
        echo '</pre></div>';
        
        if ($type == 's') //stop
        {
            exit;
        }
    }
}
