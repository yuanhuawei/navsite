<?php

/**
 * ������¼
 * 
 */
class PublicController extends Controller
{

    /**
     * �˳���¼
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        parent::_sessionRemove('_backendGroupId');
        parent::_sessionRemove('_backendGroupName');
        parent::_sessionRemove('_backendAcl');
        parent::_sessionRemove('_backendPermission');
        $this->redirect(array('public/login'));
    }

    public function actions()
    {
        return array(
        // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
    //                    'backColor'=>0xFFFFFF,  //������ɫ
                'minLength'=>4,  //���Ϊ4λ
                'maxLength'=>4,   //�ǳ�Ϊ4λ
                'transparent'=>true,  //��ʾΪ͸��
            ),
        );
    }
    
    public function actionLogin()
    {
        $model = new Admin('login');

        if (XUtils::method() == 'POST')
        {
            $model->attributes = $_POST['Admin'];

            if ($model->validate())
//            if (TRUE) //����֤�뼴�ɵ�½
            {

                $data = $model->find('username=:username', array('username' => $model->username));
                if ($data === null)
                {
                    $model->addError('username', '�û�������');
                    parent::_backendLogger(array('catalog' => 'login', 'intro' => '��¼ʧ�ܣ��û�������:' . CHtml::encode($model->username), 'user_id' => 0));
                } elseif (!$model->validatePassword($data->password))
                {
                    $model->addError('password', '���벻��ȷ');
                    parent::_backendLogger(array('catalog' => 'login', 'intro' => '��¼ʧ�ܣ����벻��ȷ:' . CHtml::encode($model->username) . '��ʹ�����룺' . CHtml::encode($model->password), 'user_id' => 0));
                } elseif ($data->group_id == 2)
                {
                    $model->addError('username', '�û��Ѿ�����������ϵ����');
                } else
                {
                    $this->_sessionSet('_backendGroupId', $data->group_id);
                    if (isset($data->group_id) && $data->group_id == 1)
                    {
                        $this->_sessionSet('_backendPermission', 'backendstrator');
                    }

                    $data->last_login_ip = XUtils::getClientIP();
                    $data->last_login_time = time();
                    $data->login_count = $data->login_count + 1;
              
                    $data->save();
                    
                    parent::_sessionSet('uid', $data->id);
                    parent::_sessionSet('uname', $data->username);
 
                    parent::_backendLogger(array('catalog' => 'login', 'intro' => '�û���¼�ɹ�:' . $data->username));
                    $this->redirect(array('default/index'));

                    XUtils::message('success', '��¼�ɹ�', $this->createUrl('default/index'), 2);
                }
            }
        }
        $this->render('login', array('model' => $model));
    }
    
}

?>