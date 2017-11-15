<?php

/**
 * ���������࣬ǰ̨����������̳д���
 * 
 */
class XFrontBase extends Controller
{

    public $layout = 'none'; //Ĭ��layout
    public $defaultAction='index'; //Ĭ�Ͽ���������
    protected $_conf;
    protected $_catalog;
    protected $_seoTitle;
    protected $_seoKeywords;
    protected $_seoDescription;
    protected $_thisUrl;

    /**
     * ��ʼ��
     * @see CController::init()
     */
    public function init()
    {
        parent::init();
        
        
        //ǰ�˿������ڴ˻�÷���,�Ӷ�������(0)��ʼ�ֲ�����ȡ,�õ����в�εķ���
//        ppr(XXcache::system('_catalog')); //�����Ǳ�������δ���մ�������
//        ppr($this->_catalog); //�������°���������
        $this->_catalog = Catalog::get(0, XXcache::system('_catalog'));
        
        //ϵͳ����
        $this->_conf = XXcache::system('_config');
        $this->_seoTitle = $this->_conf['seo_title'];
        $this->_seoKeywords = $this->_conf['seo_keywords'];
        $this->_seoDescription = $this->_conf['seo_description'];
        if ($this->_conf['site_status'] == 'close')
        {
            self::_closed();
        }  
        
        $this->_thisUrl = higu();
        if ($this->_conf['cache_page_status'] == 'open')
        {
            $value = Yii::app()->cache->get($this->_thisUrl);
            if ($value === false)
            {
                echo 'nocache';
            }else{
                echo 'cache';
                echo $value;
            }
        }
        
    }

    /**
     * ���ɵ�������
     */
    protected function _navLink($catalog)
    {
        if ($catalog['redirect_url'])
        {
            return $catalog['redirect_url'];
        } else
        {
            return $this->createUrl('post/index', array('catalog' => $catalog['catalog_name_alias']));
        }
    }

    /**
     * ��վ�رյ�״̬
     */
    protected function _closed()
    {
        $this->render('/error/close', array('message' => $this->_conf['site_status_intro']));
        exit;
    }
    
    
    
    protected function afterAction($action)
    {
        parent::afterAction($action);
//        echo 'after';
        if ($this->_conf['cache_page_status'] == 'open')
        {
            $cacheTime = $this->_conf['cache_page_time'];
            $cacheId = $this->_thisUrl;
            ob_start();
            $pageData = ob_get_contents();
            
            if (Yii::app()->cache->set($cacheId, $pageData, $cacheTime))
            {
                //��¼
                echo 'д��cache';
                CacheData::_addMycache('ҳ�滺��', $cacheId, $cacheTime, $this->_thisUrl);
            }
        }
    }
}
