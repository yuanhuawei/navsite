<?php

!defined('SITE_URL') && exit('Forbidden'); //��index.php����
//��̨��menu

function backendMenu($c = null, $a = null)
{
    $re = array(
        'ȫ������' => array(
            'controller' => 'config',
            'acl' => 'config',
            'action' => array(
                array(
                    'name' => '��վ��Ϣ',
                    'url' => 'default/welcome',
                    'acl' => 'default_welcome',
                    'list_acl' => array()
                ),
                array(
                    'name' => 'ͬ������',
                    'url' => 'links/tbAll',
                    'acl' => 'links_tball',
                    'list_acl' => array()
                ),
                array(
                    'name' => 'վ������',
                    'url' => 'config/info',
                    'acl' => 'config_info',
                    'list_acl' => array()
                ),
                array(
                    'name' => '��ջ���',
                    'url' => 'config/cache',
                    'acl' => 'config_cache',
                    'list_acl' => array()
                ),
            )
        ),
        
        '���ݷ���' => array(
            'controller' => 'links',
            'acl' => 'links',
            'action' => array(
                array(
                    'name' => '������',
                    'url' => 'catalog/index',
                    'acl' => 'catalog_index',
                    'list_acl' => array(
                        '¼��' => 'catalog_create',
                        '�༭' => 'catalog_update',
                        'ɾ��' => 'catalog_delete',
                        '����' => 'catalog_sort_order',
                        '����' => 'catalog_unverify',
                        '��ʾ' => 'catalog_verify'
                    )
                ),
                array(
                    'name' => '�����б�',
                    'url' => 'links/index',
                    'acl' => 'links_index',
                    'list_acl' => array(
                        '¼��' => 'links_create',
                        '�༭' => 'links_update',
                        '�������' => 'links_verify',
                        '�����Ƽ�' => 'links_commend',
                        'ɾ��' => 'links_delete'
                    )
                ),
                array(
                    'name' => '�������',
                    'url' => 'links/create',
                    'acl' => 'links_create',
                    'list_acl' => array()
                ),
                array(
                    'name' => '�������',
                    'url' => 'links/createBatch',
                    'acl' => 'links_createbatch',
                    'list_acl' => array()
                ),
                array(
                    'name' => '��������',
                    'url' => 'links/createImport',
                    'acl' => 'links_createimport',
                    'list_acl' => array()
                ),
            )
        ),

        '�û�����' => array(
            'controller' => 'admin',
            'url' => 'admin/index',
            'acl' => 'user',
            'action' => array(
                array(
                    'name' => '����Ա�б�',
                    'url' => 'admin/index',
                    'acl' => 'admin_index',
                    'list_acl' => array(
                        '¼��' => 'admin_create',
                        '�༭' => 'admin_update',
                        'ɾ��' => 'admin_delete'
                    )
                ),
                array(
                    'name' => '�������б�',
                    'url' => 'admin/group',
                    'acl' => 'admin_group',
                    'list_acl' => array(
                        '¼��' => 'admin_groupcreate',
                        '�༭' => 'admin_groupupdate',
                        'ɾ��' => 'admin_group_delete'
                    )
                ),

                array(
                    'name' => '����Ա��־',
                    'url' => 'admin/logger',
                    'acl' => 'admin_logger',
                    'list_acl' => array(
                        'ɾ��' => 'admin_logger_delete'
                    )
                ),
            )
        ),
        'ҳ������' => array(
            'controller' => 'html',
            'acl' => 'html',
            'action' => array(
                array(
                    'name' => '����ҳ��',
                    'url' => 'html/create',
                    'acl' => 'html_create',
                    'list_acl' => array(
                        '������ҳ'=>'html_createIndex',
                        '������ҳ'=>'html_createInner',
                    )
                ),
            )
        ),
        '114������' => array(
            'controller' => 'union',
            'acl' => 'union',
            'action' => array(
                array(
                    'name' => '114������',
                    'url' => 'union/index',
                    'acl' => 'union_index',
                    'list_acl' => array()
                ),
            )
        ),
    );

    //������controller��action,��������м
    if ($c && $a)
    {
        $temp = $tempfirst = null;
        $i = $ii = 1;
        foreach ($re as $key => $value)
        {
            foreach ($value['action'] as $k => $v)
            {
                if ($c . '/' . $a == $v['url'])
                {
                    $temp = array('c' => $key, 'a' => $v['name']);
                    break;
                }

                if ($i == 1 && $ii == 1)
                {
                    $tempfirst = array('c' => $key, 'a' => $v['name']);
                }
                $ii++;
            }
            $i++;
        }
        if (empty($temp))
        {
            $re = $tempfirst;
        } else
        {
            $re = $temp;
        }
        unset($temp, $tempfirst);
    }

    return $re;
}

/**
 * ���Ǽ򻯵� Yii::app()
 */
function app()
{
    return Yii::app();
}

/**
 * ���Ǽ򻯵� Yii::app()->clientScript
 */
function gcs()
{
// You could also call the client script instance via Yii::app()->clientScript
// But this is faster
    return Yii::app()->getClientScript();
}

/**
 * ���Ǽ򻯵� Yii::app()->user.
 */
function user()
{
    return Yii::app()->getUser();
}

/**
 * ���Ǽ򻯵� Yii::app()->createUrl()
 */
function url($route, $params = array(), $ampersand = '&')
{
    return Yii::app()->createUrl($route, $params, $ampersand);
}

/**
 * ���Ǽ򻯵� CHtml::encode
 */
function h($text)
{
    return htmlspecialchars($text, ENT_QUOTES, Yii::app()->charset);
}

/**
 * ���Ǽ򻯵� CHtml::link()
 */
function l($text, $url = '#', $htmlOptions = array())
{
    return CHtml::link($text, $url, $htmlOptions);
}

/**
 * ���Ǽ򻯵� Yii::t() with default category = 'stay'
 */
function t($message, $category = 'stay', $params = array(), $source = null, $language = null)
{
    return Yii::t($category, $message, $params, $source, $language);
}

/**
 * ���Ǽ򻯵� Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function bu($url = null)
{
    static $baseUrl;
    if ($baseUrl === null)
    {
        $baseUrl = Yii::app()->getRequest()->getBaseUrl();
    }
    return $url === null ? $baseUrl : $baseUrl . '/' . ltrim($url, '/');
}

/**
 * Returns the named application parameter.
 * ���Ǽ򻯵� Yii::app()->params[$name].
 */
function param($name)
{
    return Yii::app()->params[$name];
}

/**
 * A useful one that I use in development is the following
 * which dumps the target with syntax highlighting on by default
 */
function dump($target)
{
    return CVarDumper::dump($target, 10, true);
}

function ebr($param, $stop = 0)
{
    echo '<hr>';
    echo $param;
    echo '<hr><br />';
    if ($stop)
    {
        exit();
    }
}

function ppr($param, $stop = 0)
{
    echo '<hr>';
    echo "<meta http-equiv=\"content-type\" content=\"text/html;charset=utf-8\">";
    echo '<pre>';
    print_r($param);
    echo '</pre><hr>';
    if ($stop)
    {
        
        exit();
    }
}

/**
 * ����һ��a��ǩ������
 * htmlentities ת��<>�ȷ���, html_entity_decode����ת
 * addslashes �� ' "" ת��������
 */
function aurl($text, $url, $blank = NULL)
{
    isset($blank) && $blank = "target='_blank'";
    return addslashes(htmlentities("<a href='{$url}' {$blank}>{$text}</a>"));
}

function req()
{
    return Yii::app()->request;
}

/*
 * ����get,����links
 */

function reqReq($param)
{
    return Yii::app()->request->getParam($param);
}

/*
 * get
 */

function reqGet($param,$defaultValue=null)
{
    return Yii::app()->request->getQuery($param,$defaultValue);
}

function reqGetNum($param,$defaultValue=0)
{
    return intval(Yii::app()->request->getQuery($param,$defaultValue));
}

/*
 * links
 */

function reqPost($param,$defaultValue=null)
{
    return Yii::app()->request->getPost($param,$defaultValue);
}

function reqPostNum($param,$defaultValue=null)
{
    return intval(Yii::app()->request->getPost($param,$defaultValue));
}

/*
 * �Ƿ���links
 */

function isPost()
{
    return Yii::app()->request->getIsPostRequest();
}

/*
 * ��ǰҳ���������URL
 * /newmood/index.php?r=backend/database/index
 */

function gu()
{
    return Yii::app()->request->getUrl();
}

/*
 * ��ǰ����
 * http://localhost
 */

function hi()
{
    return Yii::app()->request->hostInfo;
}

function higu()
{
    return hi() . gu();
}

/*
 * �����������ҳ��ַ
 * /newmood/index.php
 */

function ru()
{
    return Yii::app()->getUser()->returnUrl;
}

/*
 * ��������ĸ�Ŀ¼��ַ
 * /newmood/index.php
 */

function hu()
{
    return Yii::app()->homeUrl;
}

/*
 * ��ȡ������Ϣ
 * http://localhost
 */

function getHostInfo()
{
    return Yii::app()->request->getHostInfo();
}

/*
 * ��ȡ��Ŀ¼
 * /newmood
 */

function getBaseUrl()
{
    return Yii::app()->request->getBaseUrl();
}

/*
 * ��ȡ��ǰurl
 * /newmood/index.php
 */

function getScriptUrl()
{
    return Yii::app()->request->getScriptUrl();
}

function getUrlRef()
{
    return Yii::app()->request->urlReferrer;
}

/*
 * ��ȡ�û�ip��ַ
 * 127.0.0.1
 */

function getTureIp()
{
    return Yii::app()->request->getUserHostAddress();
}

/*
 * ��ȡ�û���������
 */

function getUserHost()
{
    return Yii::app()->request->getUserHost();
}

/*
 * cache GET
 */

function cacheGet($id)
{
    return Yii::app()->cache->get($id);
}

/*
 * cache SET
 */

function cacheSet($id, $value, $time = 3600)
{
    Yii::app()->cache->set($id, $value, $time);
}

/*
 * cache Clean
 */

function cacheDelete($id)
{
    Yii::app()->cache->delete($id);
}

/*
 * cache Flush
 */

function cacheFlush()
{
    Yii::app()->cache->flush();
}

function getUid()
{
    if (!empty(Yii::app()->user->id))
    {
        return Yii::app()->user->id;
    }

    return FALSE;
}

function getUname()
{
    if (!empty(Yii::app()->user->name))
    {
        return Yii::app()->user->name;
    }

    return FALSE;
}

function xEcho($param=null)
{
    if (empty($param))
    {
        if (isset($param))
        {
            echo 0;
        }  else
        {
            echo '';
        }
    }  else
    {
        echo $param;
    }
}

?>