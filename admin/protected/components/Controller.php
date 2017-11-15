<?php

/**
 * ���������࣬ǰ�ˣ���˾���̳д���
 */
class Controller extends CController
{

    public $layout;
    protected $_gets;
    protected $_hostInfo;
    protected $_getUrl;
    protected $_baseUrl;
    protected $_conf;
    protected $_theme;
    protected $_thetime;
    protected $_v = '2.0';
    protected $_vRelease = '20140815';

    /**
     * ��ʼ��
     * @see CController::init()
     */
    public function init()
    {
        $this->layout = FALSE;
        $this->_gets = Yii::app()->request;
        $this->_hostInfo = Yii::app()->request->hostInfo; //* http://localhost
        $this->_getUrl = Yii::app()->request->getUrl(); //* /backend/index.php?r=backend/database/index
        $this->_baseUrl = Yii::app()->baseUrl; //*   /backend
        $this->_thetime = time();
    }

    /*
      ���ִ�� :��ʾִ��ʱ�估�ڴ�
      @see CController::afterAction()
     */
    protected function afterAction($action)
    {
        $time = sprintf('%0.5f', Yii::getLogger()->getExecutionTime());
        $memory = round(memory_get_peak_usage() / (1024 * 1024), 2) . "MB";
        echo '<!-- Time: ' . $time . 'ms, memory: ' . $memory . '-->';
        parent::afterAction($action);
    }

    /**
     * ����cookie
     */
    protected function _cookiesSet($name = '', $value = '', $expire = 3600, $path = '', $domain = '', $secure = false)
    {
        $cookieSet = new CHttpCookie($name, $value);
        //��Чʱ��
        $expire && $cookieSet->expire = $expire;
        //���·��
        $path && $cookieSet->path = $path;
        //�����ռ�
        $domain && $cookieSet->domain = $domain;
        
        $secure && $cookieSet->secure = $secure;
        Yii::app()->request->cookies[$name] = $cookieSet;
    }

    /**
     * ��ȡcookie
     */
    protected function _cookiesGet($name, $once = false)
    {
        $cookie = Yii::app()->request->getCookies();
        $data = $cookie[$name]->value;
        if ($once)
        {
            unset($cookie[$name]);
        }
        return $data;
    }

    /**
     * ����cookie
     * @param  $name
     */
    protected function _cookiesRemove($name)
    {
        $cookie = Yii::app()->request->getCookies();
        unset($cookie[$name]);
    }

    /**
     * ����session
     *
     * @param data ����,����������
     */
    protected function _sessionSet($name, $value = '')
    {
        if (!empty($name) && !empty($value) && (is_string($name) || is_numeric($name)))
        {
            Yii::app()->session->add($name,$value);
        }
    }

    /**
     * ��ȡsession
     */
    protected function _sessionGet($name, $once = false)
    {
        if (!empty($name) && (is_string($name) || is_numeric($name)))
        {
            $data = Yii::app()->session[$name];
            if ($once)
            {
                unset(Yii::app()->session[$name]);
            }
            return $data;
        }  else
        {
            return FALSE;
        }
    }

    /**
     * ���session
     */
    protected function _sessionRemove($name)
    {
        unset(Yii::app()->session[$name]);
    }

    /**
     * �汾��Ϣ
     */
    public function actionVersion()
    {
        exit($this->_v . ' ' . $this->_vRelease);
    }

    /**
     * ������Ŀ
     */
    protected function _dataLoad($model, $condition, $type = 'pk', array $params = array())
    {
        if ($type == 'attr')
        {
            $data = $model->findByAttributes($condition);
        } else
        {
            if ($type == 'string')
            {
                $data = $model->find($condition, $params);
            } else
            {
                $data = $model->findByPk($condition);
            }
            if ($data)
            {
                return $data;
            } else
            {
                throw new CHttpException(404, '��¼������');
            }
        }
    }

    /**
     * �����������õ����ļ�
     */
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'minLength' => 1,
                'maxLength' => 5,
                'backColor' => 0xFFFFFF,
                'width' => 100,
                'height' => 40
            )
        );
    }

    /**
     * ��̨��־��¼
     * @param  $intro
     */
    protected function _backendLogger(array $arr = array())
    {
        if (Config::get('admin_logger') == '1')
        {
            $model = new AdminLogger();
            $model->attributes = $arr;
            $model->user_id = intval(Yii::app()->user->id);
            $model->url = Yii::app()->request->getRequestUri();
            $model->ip = XUtils::getClientIP();
            $model->create_time = time();
            $model->save();
        }
    }

    /**
     * ��̨��־��¼
     * @param  $intro
     */
    protected function _userLogger(array $arr = array())
    {
        $model = new UserLogger();
        $model->attributes = $arr;
        !isset($arr['user_id']) && $model->user_id = intval(self::_sessionGet('_userId'));
        $model->url = Yii::app()->request->getRequestUri();
        $model->ip = XUtils::getClientIP();
        $model->save();
    }

    /**
     * �༭���ļ��ϴ�
     */
    public function actionUpload()
    {
        if (XUtils::method() == 'POST')
        {
            $accountUserId = self::_sessionGet('accountUserId');
            //$backendUserId = self::_sessionGet('backendUserId');
            $file = XUpload::upload($_FILES['imgFile']);
            if (is_array($file))
            {
                $model = new Upload();
                $model->user_id = intval($accountUserId);
                $model->file_name = $file['pathname'];
                $model->thumb_name = $file['paththumbname'];
                $model->real_name = $file['name'];
                $model->file_ext = $file['extension'];
                $model->file_mime = $file['type'];
                $model->file_size = $file['size'];
                $model->save_path = $file['savepath'];
                $model->hash = $file['hash'];
                $model->save_name = $file['savename'];
                $model->create_time = time();
                if ($model->save())
                {
                    exit(CJSON::encode(array('error' => 0, 'url' => Yii::app()->baseUrl . '/' . $file['pathname'])));
                } else
                {
                    @unlink($file['pathname']);
                    @unlink($file['paththumbname']);
                    exit(CJSON::encode(array('error' => 1, 'message' => '�ϴ�����')));
                }
            } else
            {
                exit(CJSON::encode(array('error' => 1, 'message' => '�ϴ�����')));
            }
        }
    }

}
