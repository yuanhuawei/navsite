<?php

/**
 * ��̨��������࣬��̨����������̳д���
 */
class XBackendBase extends Controller
{

    protected $_backendUserId;
    protected $_backendUserName;
    protected $_backendGroupId;
    protected $_backendGroupName;
    protected $_backendPermission;
    protected $_backendAcl;
    protected $_catalog;
    protected $_catalogAll;

    public function init()
    {
        //��ʼ��
        parent::init();
        
        //����session
        if (isset($_POST['sessionId']))
        {
            $session = Yii::app()->getSession();
            $session->close();
            $session->sessionID = $_POST['sessionId'];
            $session->open();
        }

        //�ӳ�ʼ������������ȡ��userid,��������֤���е�¼
        $this->_backendUserId = parent::_sessionGet('uid');
        $this->_backendUserName = parent::_sessionGet('uname');
        $this->_backendGroupId = parent::_sessionGet('_backendGroupId');

        /* ����ж��Ƿ��½,��������loginҳ�� */
        empty($this->_backendUserId) && $this->redirect(array('public/login'));
        empty($this->_backendGroupId) && $this->redirect(array('public/login'));
        
        $this->_backendGroupName = parent::_sessionGet('_backendGroupName');
        $this->_backendPermission = parent::_sessionGet('_backendPermission');
        $this->_backendAcl = parent::_sessionGet('_backendAcl');
        
        if(empty($this->_backendAcl) || empty($this->_backendGroupName))
        {
            $groupArr= AdminGroup::model()->findByPk($this->_backendGroupId);
            //��ǰ��Ȩ��
            $this->_backendAcl = $groupArr->acl;
            parent::_sessionSet('_backendAcl',  $this->_backendAcl);
            
            //��ǰ��id
            $this->_backendGroupId = $groupArr->id;
            parent::_sessionSet('_backendGroupId', $this->_backendGroupId);
            
            //��ǰ����
            $this->_backendGroupName = $groupArr->group_name;
            parent::_sessionSet('_backendGroupName', $this->_backendGroupName);
            
            unset($groupArr);
        }
        
        //��Ŀ,����ڴ˻��ȫ��������,ǰ����system������
        $this->_catalog = XXcache::get('_catalog');
        $this->_catalogAll = XXcache::get('_catalogAll');
        
        //ϵͳ����
        $this->_conf = XXcache::get('_config');

        $this->_theme = empty($this->_conf['theme'])?'default':$this->_conf['theme'];
//        $this->_conf = self::_config();
        
        //վ��ǰ̨���⾲̬Ŀ¼url
        !defined('STATIC_THEME_URL') && define('STATIC_THEME_URL', SITE_URL . 'static/themes/' . $this->_theme . '/');
                
        
    }

    /**
     * �����ļ��в������
     */
    protected function _configParams($params)
    {
        if (Yii::app()->params[$params['action']] != $params['val'] && $params['response'] == 'json')
        {
            exit(CJSON::encode(array('state' => 'error', 'message' => $params['message'])));
        } elseif (Yii::app()->params[$params['action']] != $params['val'] && $params['response'] == 'text')
        {
            exit($params['message']);
        } elseif (Yii::app()->params[$params['action']] != $params['val'])
        {
            $tplVar = array(
                'code' => '��������',
                'message' => $params['message'],
                'redirect' => $params['redirect'] ? $params['redirect'] : Yii::app()->request->urlReferrer,
            );
            exit($this->render('/_include/_error', $tplVar));
        }
    }

    /**
     * ʵʱ��ȡϵͳ����
     * @return [type] [description]
     */
    private function _config()
    {
        $model = Config::model()->findAll();
        $config = null;
        foreach ($model as $row)
        {
            if (!empty($row['variable']))
            {
               $config[$row['variable']] = $row['value'];
            }
        }
        return $config;
    }

    /**
     * ���»���
     *
     * @param $model ģ��
     * @param $field �ֶ�
     * @param $redirect ��ת
     * @param $tpl ģ��
     * @param $pkField ����id
     */
    protected function _update($model, $redirect = 'index', $tpl = '', $id = 0, $pkField = 'id', $field = '')
    {
        $modelName = !$field ? get_class($model) : $field;
        $data = $model->findByPk($id);
        empty($data) && XUtils::message('error', '��¼������');
        if (isset($_POST[$modelName]))
        {
            $data->attributes = $_POST[$modelName];
            if ($data->save())
            {
                self::_backendLogger(array('catalog' => 'update', 'intro' => '���û���������ݣ�����ģ�飺' . $this->id . '��������' . $this->action->id)); //��־
                $this->redirect($redirect);
            }
        }
        $this->render($tpl, array('model' => $data));
    }

    /**
     * ¼�����
     *
     * @param $model ģ��
     * @param $field �ֶ�
     * @param $redirect ��ת
     * @param $tpl  ģ��
     */
    protected function _create($model, $redirect = 'index', $tpl = '', $field = false)
    {
        $modelName = !$field ? get_class($model) : $field;

        if (isset($_POST[$modelName]))
        {
            $model->attributes = $_POST[$modelName];
            $id = $model->save();
            if ($id)
            {
                self::_backendLogger(array('catalog' => 'update', 'intro' => '���û���¼�����ݣ�����ģ�飺' . $this->id . '��������' . $this->action->id . ',ID:' . $id)); //��־
                $this->redirect($redirect);
            }
        }
        $this->render($tpl, array('model' => $model));
    }

    /**
     * ɾ�����ݼ�����
     *
     * @param $model  ģ��
     * @param $id  Ҫɾ��������id
     * @param $redirect ��ת��ַ
     * @param $attach �����ֶ�
     * @param $conditionField ����id
     */
    protected function _delete($model = null, $id = '', $redirect = 'index', $attach = null, $pkField = 'id')
    {
        if ($attach)
        {
            $data = $model->findAll($pkField . ' IN(:id)', array(':id' => $id));
            foreach ((array) $data as $row)
            {
                foreach ((array) $attach as $value)
                {
                    if (!empty($row[$value]))
                    {
                        @unlink($row[$value]);
                    }
                }
            }
        }
        $model->deleteAll(array('condition' => 'id IN(' . $id . ')'));
        //ˢ�»���
        self::_refreshCache($model);
        $this->redirect($redirect);
    }

    /**
     * ��˻�����
     *
     * @param $model
     * @param $type
     * @param $id
     * @param $redirect
     * @param $attach
     * @param $pkField
     */
    protected function _verify($model = null, $type = 'verify', $id = '', $redirect = 'index', $cdField = 'status_is', $pkField = 'id')
    {
        $criteria = new CDbCriteria();
        $criteria->condition = $pkField . ' IN(' . $id . ')';
        $showStatus = $type == 'verify' ? 'Y' : 'N';
        $model->updateAll(array($cdField => $showStatus), $criteria);
        //ˢ�»���
        self::_refreshCache($model);
        $this->redirect($redirect);
    }

    /**
     * �Ƽ�������
     *
     * @param $model
     * @param $type
     * @param $id
     * @param $redirect
     * @param $attach
     * @param $pkField
     */
    protected function _commend($model = null, $type = 'commend', $id = '', $redirect = 'index', $pkField = 'id')
    {
        $criteria = new CDbCriteria();
        $criteria->condition = $pkField . ' IN(' . $id . ')';
        $commend = $type == 'commend' ? 'Y' : 'N';
        $model->updateAll(array('commend' => $commend), $criteria);
        //ˢ�»���
        self::_refreshCache($model);
        $this->redirect($redirect);
    }

    /**
     * ˢ�����û���
     * @param  $model
     */
    protected function _refreshCache($model)
    {
        if (is_object($model))
        {
            $modelx = get_class($model);
        } else
        {
            $modelx = $model;
        }
        switch (strtolower($modelx))
        {
            case 'link':
                XXcache::refresh('_link', 86400);
                break;
            case 'ad':
                XXcache::refresh('_ad', 86400);
                break;
            case 'catalog':
                XXcache::refresh('_catalog', 86400);
                break;
            case 'UserGroup':
                XXcache::refresh('_userGroup', 86400);
                break;
        }
    }

    /**
     * ϵͳ���ֹ����
     * @param $group
     * @throws CHttpException
     */
    protected function _groupPrivate($groupId = 0, $noAccess = array('1', '2'))
    {
        if (is_array($groupId))
        {
            foreach ($groupId as $value)
            {
                if (in_array($value, $noAccess))
                {
                    throw new CHttpException(404, 'ϵͳ�鲻������д˲���');
                }
            }
        } else
        {
            if (in_array($groupId, $noAccess))
            {
                throw new CHttpException(404, 'ϵͳ�鲻������д˲���');
            }
        }
    }

    /**
     * ȡ�û����б�
     * @param $type
     */
    protected function _groupList($type = 'admin')
    {
        if ($type == 'admin')
        {
            return AdminGroup::model()->findAll();
        }  else
        {
            return FALSE;
        }
    }

    /**
     * Ȩ�޼��
     * �����û����������
     * ���� index_index ��̨��ҳ,��ֹ�ظ���֤Ȩ��
     * @param $action
     */
    protected function _acl($action = false, $params = array('response' => false, 'append' => 'default_index|'))
    {
        //��actionΪ��,��ʹ��path���
        $actionFormat = empty($action) ? strtolower($this->id . '_' . $this->action->id) : strtolower($action);
        //�ж��Ƿ�admin
        $permission = $this->_backendPermission;

        //����admin��ʱ��
        if ($permission != 'backendstrator')
        {
            try
            {
                if (FALSE === strpos($this->_backendAcl. $params['append'], '|'.$actionFormat.'|'))
                {
                    throw new Exception('��ǰ��ɫ����Ȩ�޽��д˲���������ϵ����Ա��Ȩ');
                }
            } catch (Exception $e)
            {

                if ($params['response'] == 'text')
                {
                    exit($e->getMessage());
                } elseif ($params['response'] == 'json')
                {
                    $var['state'] = 'error';
                    $var['message'] = $e->getMessage();
                    exit(CJSON::encode($var));
                } else
                {
                    $referrer = Yii::app()->request->urlReferrer ? Yii::app()->request->urlReferrer : $this->createUrl('default/welcome');
                    if (preg_match("/default\/index/i", $referrer))
                    {
                        $referrer = $this->createUrl('default/welcome');
                    }
                    $tplVar = array(
                        'code' => '��������',
                        'message' => $e->getMessage(),
                        'redirect' => !empty($params['redirect']) ? $params['redirect'] : $referrer,
                    );
                    exit($this->render('/_common/_error', $tplVar));
                }
            }
        }
    }
    
    /**
     * ����ͼƬ�ϴ�
     * @param type $imageField ͼƬ�ֶ�
     * @return null
     */
    protected function _doLocalImage($imageField='image_link')
    {

        $file = $image_link = null;
        if (!empty($_FILES[$imageField]) && !empty($_FILES[$imageField]['name']))
        {
            $file = XUpload::upload(
                $_FILES[$imageField], array(
                    'thumb' => false,
                    'allowExts' => $this->_conf['upload_allow_ext'],
                    'maxSize' => $this->_conf['upload_max_size']*1024,
                    'saveRule' => array(
                        'rule' => 'default',
                        'format' => 'Ymd',
                        'path' => DIR_UPLOADS,
                    )
                )
            );
        }
        if (!empty($file) && is_array($file) && isset($file['name']))
        {
            if (!empty($_POST['oldpicname']))
            {
                $oldname = str_replace($file['savename'], $file['name'], $file['pathname']);
                // ɾ��ͬ��ͼƬ
                is_file($oldname) && unlink($oldname);
                //����Ϊԭ��
                rename($file['pathname'],$oldname);
                $image_link = str_replace(DIR_UPLOADS, '', $file['savepath'].$file['name']);
            }  else
            {
                $image_link = str_replace(DIR_UPLOADS, '', $file['pathname']);
            }
        }
//                ppr($image_link,1);
        return $image_link;
    }
    
    /**
     * �õ������id
     * @param type $id
     */
    protected function _getParentCatalogId($id)
    {
        $fid = 0;
        foreach ($this->_catalog as $cv)
        {
            if ($cv['id'] == $id)
            {
                $fid = $cv['parent_id'];
                break;
            }
        }
        return $fid;
    }
    
    /**
     * һ������id�������ӷ���,�Ƿ���ײ�,�Ƿ����ų�
     * @param type $fid
     * @param type $last
     * @param type $notArr
     * @return type
     */
    function getChildCatalogId($fid,$last=null,$notArr=array())
    {
        $re= array();
        foreach ($this->_catalog as $cv)
        {
            if ($cv['parent_id'] == $fid && !in_array($cv['id'], $notArr))
            {
                if (!isset($last) || (isset($last) && $cv['last'] == $last))
                {
                    $re[$cv['id']] = $cv;
                }
            }
        }
        return $re;
    }
    
}
