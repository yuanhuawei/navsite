<?php

/**
 * ϵͳ����
 * 
 */
class CatalogController extends XBackendBase
{

    /**
     * ��ҳ
     */
    public function actionIndex()
    {
//        cacheFlush();
        parent::_acl();
        $fid = reqGet('fid',0);
        $rootCatalog = $dataList = null;
        //��������
//        ppr($this->_catalogAll);
        foreach ($this->_catalogAll as $key => $value)
        {
            $value['parent_id']==0 && $rootCatalog[$value['id']] = $value['catalog_name']; 
        }

        $fid>0 && $dataList = XXcache::_doCatalog($fid, $this->_catalogAll); 
//        ppr($dataList);
        empty($dataList) && $dataList = $this->_catalogAll;
        
        //�õ�����������������,����õ����з���������,����
        $catalogLinksNum = $this->_getCatalogLinksNum();
        
        foreach ($dataList as $key => $value)
        {
            if ($value['last'])
            {
                $dataList[$key]['num'] = empty($catalogLinksNum[$value['id']])?0:$catalogLinksNum[$value['id']];
            }
        }
        
        unset($catalogLinksNum);
        
        $this->render('index', array('dataList' => $dataList,'rootCatalog'=>$rootCatalog,'fid'=>$fid));
//        ppr($this->_catalog);        ppr($dataList);
    }

    protected function _getCatalogLinksNum($cid=null)
    {
        if (empty($cid))
        {
            return XXcache::get('_catalogAllNum');
        }  else
        {
            $cid = (int)$cid;
            return Links::model()->count("`catalog_id` = '$cid'");
        }
        
    }




    /**
     * ¼��
     *
     */
    public function actionCreate()
    {
//        parent::_acl();
//        ppr($this->_catalogAll,1);
        parent::_acl();
        $model = new Catalog();
        
        //����ѡ�񸸷����
        $parentId = reqGet('fid');
        
        if (!empty($parentId))
        {
            $model->attributes = array('parent_id' => (int)$parentId);
        }
        
        $catalogAll = reqPost('Catalog');
        if (!empty($catalogAll))
        {
            $catalogAll['create_time'] = $this->_thetime;
            //���ж�������ͼƬ���Ǳ���ͼƬ
            $imgtype = reqPost('imgtype',null);
            //ppr($_POST,1);
            if (!empty($imgtype))
            {
                if ($imgtype == 'local')
                {
                     $catalogAll['image_link'] = $this->_doLocalImage('image_link');   
                }

                if (empty($catalogAll['image_link']))
                {
                    $catalogAll['image_link'] = null;
                }
            }
            $model->attributes = $catalogAll;
//            ppr($catalogAll,1);
            unset($catalogAll);

            if ($model->save())
            {
                XXcache::refresh('_catalog');
                XXcache::refresh('_catalogAll');
                parent::_backendLogger(array('catalog' => 'create', 'intro' => '¼��ȫ�ַ���,������ID:' . $model->parent_id . '���ƣ�' . $model->catalog_name));
                
                $fid = $this->_getParentCatalogId($model->parent_id);

                $this->redirect(array('index','fid'=>$fid));
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * �༭
     *
     * @param  $id
     */
    public function actionUpdate($id)
    {
        parent::_acl();
        $model = parent::_dataLoad(new Catalog(), $id);
        $catalogAll = reqPost('Catalog');
        if (!empty($catalogAll))
        {
            $catalogAll['create_time'] = $this->_thetime;
            
            //���ж�������ͼƬ���Ǳ���ͼƬ
            $imgtype = reqPost('imgtype',null);
            //ppr($_POST,1);
            if (!empty($imgtype))
            {
                if ($imgtype == 'local')
                {
                     $catalogAll['image_link'] = $this->_doLocalImage('image_link');   
                }

                if (empty($catalogAll['image_link']))
                {
                    $catalogAll['image_link'] = null;
                }
            }
            
            $model->attributes = $catalogAll;
//        ppr($_POST);        ppr($_FILES);        ppr($catalogAll,1);
            unset($catalogAll);
            if ($model->save())
            {
                //��鸸�����Ƿ�ΪN
                $fmodel = Catalog::model()->findByPk($model->attributes['parent_id'],"`status_is`='N'");
                
                if (empty($fmodel))
                {
                    if ($model->attributes['status_is'] == 'N')
                    {
                        //���÷���ΪN,��÷��������ӷ����ΪN
                        $this->subSetStatus($model->attributes['id']);
                    }
                }  else
                {
                    //����,��ø������������о�ΪN
                    $this->subSetStatus($fmodel->attributes['id']);
                }
                
                XXcache::refresh('_catalog');
                XXcache::refresh('_catalogAll');
                parent::_backendLogger(array('catalog' => 'update', 'intro' => '�༭ȫ�ַ���,ID:' . $model->id . ',���ƣ�' . $model->catalog_name));
                $fid = $this->_getParentCatalogId($model->parent_id);

                $this->redirect(array('index','fid'=>$fid));
            }
        }

        $this->render('update', array('model' => $model,'id'=>$id));
    }

    private function subSetStatus($fid,$set='N')
    {
        $data = Catalog::model()->findAll(
            array(
                'select' => 'id',
                'condition' => 'parent_id=:fid',
                'params' => array(':fid' => $fid)
            )
        );
        if (!empty($data))
        {
            foreach ($data as $value)
            {
                Catalog::model()->updateByPk($value->id,array('status_is'=>'N'));
                $this->subSetStatus($value->id);
            }
        }
        
//        ppr($data,1);
    }


    public function actionDelete()
    {
        parent::_acl();
        $catalogId = reqGet('catalogId',null);
//        ppr($_REQUEST,1);
        if (!empty($catalogId))
        {
            $catalogId = intval($catalogId);
            $model = Catalog::model()->findByPk($catalogId);
            $name = $model->catalog_name;
            $model->delete();
            XXcache::refresh('_catalog');
            XXcache::refresh('_catalogAll');
            
            $model = Links::model()->deleteAll('catalog_id=:cid',array(':cid'=>$catalogId)); 
            
            parent::_backendLogger(array('catalog' => 'delete', 'intro' => 'ɾ������ '.$name.'('.$catalogId.') ���÷�����������'));
            
            XUtils::message('success', '��ɾ������ '.$name.' ���÷�����������');
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }
    
    
    /**
     * ����ϼ������Ƿ�Ϸ�
     *
     * @param  $item
     * @param  $parentId
     */
    protected function parentTrue($item = 0, $parentId = 0)
    {
        $subCategory = Catalog::get($item, $this->_catalog);
        if (empty($subCategory))
        {
            $getCategory[] = $item;
        } else
        {
            foreach ((array) $subCategory as $row)
            {
                $getCategory[] = $row['id'];
            }
            //������ID���������
            array_push($getCategory, $item);
        }
        if (in_array($parentId, $getCategory))
        {
            XUtils::message('error', '��ѡ����ϼ����಻���ǵ�ǰ������ߵ�ǰ������¼�����');
        }
    }


}
