<?php

/**
 * ����Ա
 * 
 */
class AdminController extends XBackendBase
{

    protected $group_list;

    /**
     * ����Ա�б�
     *
     */
    public function actionIndex()
    {
//        ppr($this->group_list);
        parent::_acl();
        $model = new Admin();
        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';
        $criteria->with = 'adminGroup';
        $result = $model->findAll($criteria);
        $this->render('index', array('datalist' => $result));
    }

    /**
     * ����Ա¼��
     *
     */
    public function actionCreate()
    {
        parent::_acl();
        $model = new Admin('create');
        //���е��û���
        $group = XXcache::get('_adminGroup');
//        ppr($group,1);
        
        if (XUtils::method() == 'POST' && !empty($_POST['Admin']))
        {
            $post = reqPost('Admin');
            $password = $post['password'];
            
            if (empty($post['username']) || empty($post['password']) || empty($post['password2']) || $post['password'] != $post['password2'])
            {
                XUtils::message('error','�˺����벻��Ϊ��,���������������벻ͬ');
            } 
            
            $model->attributes = $post;
            $model->setAttribute('password', md5($password));

            $id = $model->save();

            if (!empty($id))
            {
                parent::_backendLogger(array('catalog' => 'create', 'intro' => '¼�����Ա:' . $model->username));
                $this->redirect(array('index'));
            }
        }
        $this->group_list = parent::_groupList('admin');
        $model->create_time = date('Y-m-d');
        $model->last_login_time = date('Y-m-d');
        $this->render('create', array('model' => $model,'group'=>$group));
    }

    /**
     * ����Ա�༭
     *
     * @param  $id
     */
    public function actionUpdate($id)
    {
        parent::_acl();
        $model = parent::_dataLoad(new Admin(), $id);
        $group = AdminGroup::model()->findAll();
        if (isset($_POST['Admin']))
        {
            $post = reqPost('Admin');

            if (empty($post['password']))
            {
                $post['password'] = $model->password;
            }  else
            {
                if (empty($post['username']) || empty($post['password2']) || $post['password'] != $post['password2'])
                {
                    XUtils::message('error','�˺����벻��Ϊ��,���������������벻ͬ');
                } 
            } 
            
            $model->attributes = $post;
            
            if (!empty($post['password']))
            {
                $model->setAttribute('password', md5($post['password']));
            }

            if ($model->save())
            {
                parent::_backendLogger(array('catalog' => 'update', 'intro' => '���¹���Ա����:' . $model->username));
                $this->redirect(array('index'));
            }
        }
        $this->group_list = parent::_groupList('admin');
        $this->render('update', array('model' => $model,'id'=>$id,'group'=>$group));
    }
    
   /**
     * ɾ��
     *
     * @param  $id
     */
    public function actionDel($id)
    {
        if($id>1){
            $model = Admin::model()->deleteByPk($id);
            parent::_backendLogger(array('admin' => 'delete', 'intro' => 'ɾ���û�'.$id));
            XXcache::refresh('_adminGroup');
        }
        $this->redirect(Yii::app()->request->urlReferrer);
    }
    
    /**
     * ����Ա��
     *
     */
    public function actionGroup()
    {

        parent::_acl();
        $model = new AdminGroup();
        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';

        $result = $model->findAll($criteria);
 
        $this->render('group', array('datalist' => $result));
    }

    /**
     * ������¼��
     *
     */
    public function actionGroupCreate()
    {
        parent::_acl();
        
        $acl = backendMenu();
        $this->groupEdite();
        $this->render('group_create', array('model' => null, 'acl' => $acl));
    }

    /**
     * ����Ա��༭
     *
     * @param  $id
     */
    public function actionGroupUpdate($id)
    {
        parent::_acl();
        
        $data = parent::_dataLoad(new AdminGroup(), $id);
        $acl = backendMenu();
        $this->groupEdite($data);

        $this->render('group_update', array('model' => $data, 'acl' => $acl));

//        ppr($data);        ppr($acl);
    }
    /**
     * ����Ա��ɾ��
     *
     * @param  $id
     */
    public function actionGroupDelete($id)
    {
        parent::_acl();
//        ppr($_REQUEST,1);
        if (!empty($id))
        {
            $id = intval($id);
            $model = Admin::model()->deleteAll('group_id=:gid',array(':gid'=>$id)); //group_id
             
            $groupInfo = AdminGroup::model()->findByPk($id);
            $name = $groupInfo->group_name;
            $model = AdminGroup::model()->deleteByPk($id); 
//            ppr($groupInfo,1);
            
            parent::_backendLogger(array('catalog' => 'delete', 'intro' => 'ɾ���û��� '.$name.'('.$id.') �����û��������û�'));
            $result = XXcache::get('_adminGroup');
            XUtils::message('success', '��ɾ������ '.$name.' ���÷�����������');
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    private function groupEdite($data=null)
    {
        if (XUtils::method() == 'POST')
        {
            if (!empty($_POST['gname']) && !empty($_POST['auth']))
            {
                $gid = reqPost('gid', null);
                $auth = '|' . implode('|', array_keys($_POST['auth'])) . '|';
                $sis = !empty($_POST['sis']) && $_POST['sis'] == 'Y' ? 'Y' : 'N';
                $attr = array(
                    'group_name' => $_POST['gname'],
                    'acl' => $auth,
                    'status_is' => $_POST['sis'],
                );

                if (!empty($gid))
                {
                    $attr['id'] = $gid;
                } else
                {
                    $attr['create_time'] = time();
                }
                

                empty($data) && $data = new AdminGroup();
                $data->attributes = $attr;

//            ppr($data);            
//            ppr($attr);            
//            ppr($_POST,1);
                if ($data->save())
                {
                    //����Ȩ�޻���
                    !empty($gid) && cacheDelete('_backendAcl' . $gid, '');
                    parent::_backendLogger(array('catalog' => 'create', 'intro' => '�༭����Ա�鼰Ȩ��' . $data->group_name));
                    XXcache::refresh('_adminGroup');
                    $this->redirect(array('group'));
                }
            } else
            {
                $gid = reqPostNum('gid');
                if ($gid > 0)
                {
                    XUtils::message('error', '��������,����ȷ��д����', $this->createUrl('admin/groupCreate', array('id' => $gid)));
                } else
                {
                    XUtils::message('error', '��������,����ȷ��д����', $this->createUrl('admin/group'));
                }
            }
        }
    }
    
    public function actionLogger()
    {
        //�����˺�
        $users = Admin::model()->findAll(array('select'=>'id,username'));
//        ppr($users);
        $uid = reqGetNum('uid');
        $model = new AdminLogger();
        $condition = '1';
        $uid && $condition = "t.`user_id`='$uid'";
        $criteria = new CDbCriteria();
        $criteria->condition = $condition;
        $criteria->order = 't.create_time DESC';
        $criteria->with = array('user');
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pageParams = XUtils::buildCondition($_GET, array('user_id','r'));
        $pages->params = is_array($pageParams) ? $pageParams : array();
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $datalist = $model->findAll($criteria);
        $this->render('logger',array('datalist'=>$datalist,'pagebar'=>$pages,'pagecount'=>$count,'users'=>$users,'uid'=>$uid));
    }

}
