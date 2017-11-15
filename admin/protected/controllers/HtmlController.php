<?php

class HtmlController extends XBackendBase
{

    public function actionCreate()
    {
        $make = reqReq('make');
        $page = $page_arr = $page_arr1 = $page_arr2 = null;
        if (!empty($make['index']))
        {
            $page = 'index';
            $page_arr = $this->actionCreateIndex();
        } elseif (!empty($make['inner']))
        {
            $page = 'inner';
            $page_arr = $this->actionCreateInner();
        } elseif (!empty($make['all']))
        {
            $page = 'all';
            $page_arr1 = $this->actionCreateIndex();
            $page_arr2 = $this->actionCreateInner();
            $page_arr = array_merge($page_arr1, $page_arr2);
            unset($page_arr1,$page_arr2);
        }

        $type = reqGet('type');

        $path_inside_page = $this->_conf['path_inside_page'];

        parent::_acl();
        $this->render('create', array('path_inside_page' => $path_inside_page, 'page' => $page,'page_arr'=>$page_arr));
//        ppr($this->_conf);
    }


    public function actionCreateIndex()
    {
        parent::_acl();

        $links = $this->_getDataPid(1); //��ҳ
        $innerCatalog = Catalog::model()->findAll("`status_is`='Y' AND `parent_id`='2'");

        $links = $this->repInnerLink($links, $innerCatalog);
        
        $code = $this->render($this->_conf['theme'] . '/index', array('x' => $links,'cb'=>  $this->_getCityBox(),'eo'=>  $this->_getEmailOption()), 1);
        $filename_html = SITE_PATH . 'index.html';
        file_put_contents($filename_html, $code, LOCK_EX);
        $filename_htm = SITE_PATH . 'index.htm';
        file_put_contents($filename_htm, $code, LOCK_EX);
        
        $code = $this->render($this->_conf['theme'] . '/games_hot_ajax', array('x' => $links), 1);
        $filename_htm = SITE_PATH . 'ajax/games_hot_ajax.htm';
        file_put_contents($filename_htm, $code, LOCK_EX);
        XUtils::iconvFile($filename_htm, 'GBK', 'UTF-8');
        
        $code = $this->render($this->_conf['theme'] . '/games_web_ajax', array('x' => $links), 1);
        $filename_htm = SITE_PATH . 'ajax/games_web_ajax.htm';
        file_put_contents($filename_htm, $code, LOCK_EX);
        XUtils::iconvFile($filename_htm, 'GBK', 'UTF-8');
        
        $code = $this->render($this->_conf['theme'] . '/games_mini_ajax', array('x' => $links), 1);
        $filename_htm = SITE_PATH . 'ajax/games_mini_ajax.htm';
        file_put_contents($filename_htm, $code, LOCK_EX);
        XUtils::iconvFile($filename_htm, 'GBK', 'UTF-8');
        
        $code = $this->render($this->_conf['theme'] . '/gouwu_ajax', array('x' => $links), 1);
        $filename_htm = SITE_PATH . 'ajax/gouwu_ajax.htm';
        file_put_contents($filename_htm, $code, LOCK_EX);
        XUtils::iconvFile($filename_htm, 'GBK', 'UTF-8');

        $code = $this->render($this->_conf['theme'] . '/yule_ajax', array('x' => $links), 1);
        $filename_htm = SITE_PATH . 'ajax/yule_ajax.htm';
        file_put_contents($filename_htm, $code, LOCK_EX);
        XUtils::iconvFile($filename_htm, 'GBK', 'UTF-8');
        
        unset($code,$links,$filename_html,$filename_htm);
        
        return array(0=>array('name'=>'��ҳ','path'=>'','error'=>0));
    }

    public function actionCreateInner()
    {
        parent::_acl();

        //��ҳ����
        $innerCatalog = Catalog::model()->findAll("`status_is`='Y' AND `parent_id`='2'");
        
//        ppr($innerCatalog,1);
        
        $page_arr = null;
        if (!empty($innerCatalog))
        {
            foreach ($innerCatalog as $pageInfo)
            {
                $page_arr[$pageInfo->id] = array(
                    'name' => $pageInfo->catalog_name,
                    'path' => $pageInfo->path,
                    'error' => 0,
                );
                try {

                    if (FALSE === strpos($pageInfo->path, 'http:'))
                    {

                        if (empty($pageInfo->path))
                        {
                            $page_arr[$pageInfo->id]['error'] = 'Ŀ¼��δ��д';
                            continue;
                        }

                        preg_match_all("/\w+/", $pageInfo->path, $re);
                        if (empty($re[0][0]))
                        {
                            $page_arr[$pageInfo->id]['error'] = 'Ŀ¼��ֻ������ĸ�����»���';
                            continue;
                        }

                        $dir = SITE_PATH . substr($this->_conf['path_inside_page'], 1) . '/' . $re[0][0] . '/';
                        if (!is_dir($dir))
                        {
                            mkdir($dir);
                            if (!is_writable($dir))
                            {
                                $page_arr[$pageInfo->id]['error'] = 'Ŀ¼д��ʧ��';
                                continue;
                            }
                        }
//                        ppr($pageInfo);ppr($this->_getDataPid($pageInfo->id));

                        $links = $this->_getDataPid($pageInfo->id);
//                        ppr($links);
                        //ͳһ��ҳģ��
                        $code = $this->render($this->_conf['theme'] . '/inner', array('info' => $pageInfo, 'links' => $links,'innerCatalog'=>$innerCatalog), 1);

                        $filename_html = $dir . 'index.html';
                        $filename_htm = $dir . 'index.htm';

                        file_put_contents($filename_html, $code, LOCK_EX);
                        file_put_contents($filename_htm, $code, LOCK_EX);
                    }  else
                    {
                        $page_arr[$pageInfo->id]['error'] = '������'.'<a href='.$pageInfo->path.' target="blank">����</a>';
                    }
                } catch (Exception $exc) {
                    continue;
                }
            }
            
            return $page_arr;
        }
    }

    private function _getDataPid($pid)
    {
        //�õ����еĸ�idΪ$pid�ķ���
        $dataList = XXcache::_doCatalog($pid, $this->_catalogAll);
        
        $dataRe = null;
        if (!empty($dataList))
        {
            foreach ($dataList as $key => $value)
            {
                $dataRe[$value['id']]['name'] = empty($value['catalog_name'])?null:$value['catalog_name'];
                $dataRe[$value['id']]['count'] = empty($value['data_count'])?null:$value['data_count'];
                $dataRe[$value['id']]['path'] = empty($value['path'])?null:$value['path'];
                $dataRe[$value['id']]['t'] = empty($value['seo_t'])?null:$value['seo_t'];
                $dataRe[$value['id']]['k'] = empty($value['seo_k'])?null:$value['seo_k'];
                $dataRe[$value['id']]['d'] = empty($value['seo_d'])?null:$value['seo_d'];
                $dataRe[$value['id']]['url'] = empty($value['redirect_url'])?null:$value['redirect_url'];
                $dataRe[$value['id']]['opt_1'] = empty($value['opt_1'])?null:$value['opt_1'];
                $dataRe[$value['id']]['opt_2'] = empty($value['opt_2'])?null:$value['opt_2'];
                if (!empty($value['last']) && !empty($value['id']))
                {
                    $dataRe[$value['id']]['data'] = $this->_getDataCid($value['id'], $value['data_count']);
                }
            }
        }
        unset($dataList);
//        ppr($dataRe,1);
        return $dataRe;
    }

    /**
     * 
     * @param type $cid
     */
    private function _getDataCid($cid, $count)
    {
        $theTime = $this->_thetime;
        $re = null;
        empty($count) && $count = 1000;
        // ״̬���� �������� 
        $params = array(':cid' => $cid);
        $sql = "
            SELECT *
            FROM {{links}}
            WHERE `status_is`='Y'
            AND `catalog_id` = :cid
            AND (`begin_time`='0' OR `begin_time` IS NULL OR `begin_time` < '$theTime')
            AND (`end_time`='0' OR `end_time` IS NULL OR  `end_time` > '$theTime')
            ORDER BY sort_order ASC
            LIMIT $count
        ";
        $data = Links::model()->findAllBySql($sql, $params);

        if (!empty($data))
        {
            foreach ($data as $key=>$value)
            {
                if (empty($value->id))
                {
                    continue;
                }

                $re[$key]['title'] = $value->title;
                $re[$key]['title_color'] = $value->title_color;
                $re[$key]['id'] = $value->id;
                $re[$key]['link'] = empty($value->link)?null:$value->link;
                $re[$key]['image_link'] = empty($value->image_link)?null:$value->image_link;
                $re[$key]['opt_a'] = empty($value->opt_a)?null:$value->opt_a;
                $re[$key]['opt_b'] = empty($value->opt_b)?null:$value->opt_b;
                $re[$key]['opt_c'] = empty($value->opt_c)?null:$value->opt_c;
                $re[$key]['mix'] = empty($value->mix)?null:$value->mix;
            }
        }
//        ppr($re);
        return $re;
    }

    private function _getEmailOption()
    {
        return array(
            1 => array(
                "1" => "@163.com",
                "2" => "@126.com",
                "3" => "@vip.163.com",
                "4" => "@sina.com",
                "5" => "@vip.sina.com",
                "6" => "@yahoo.com.cn",
                "7" => "@yahoo.cn",
                "8" => "@sohu.com",
                "9" => "@tom.com",
                "10" => "@21cn.com",
                "11" => "@yeah.net",
                "12" => "@189.cn",
                "13" => "@139.com",
                "14" => "�ٶ��ʺ�",
                "15" => "������",
                "16" => "51.com",
                "17" => "ChinaRen",
            ),
            2 => array(
                "https://www.alipay.com/user/login.htm" => "֧����",
                "http://t.sina.com.cn/" => "����΢��",
                "http://www.kaixin001.com/" => "������",
                "http://qzone.qq.com/" => "QQ�ռ�",
                "http://mail.qq.com/cgi-bin/loginpage" => "@qq.com",
                "http://mail.google.com/mail/" => "@gmail.com",
                "http://www.hotmail.com" => "@hotmail.com",
                "http://www.188.com/" => "@188.com",
            ),
        );
    }
    
    private function _getCityBox()
    {
        return array(
            "109"=>"B ����",
            "117"=>"S �Ϻ�",
            "110"=>"T ���",
            "135"=>"C ����",
            "119"=>"A ����",
            "123"=>"F ����",
            "127"=>"G �㶫",
            "128"=>"G ����",
            "137"=>"G ����",
            "131"=>"G ����",
            "111"=>"H �ӱ�",
            "124"=>"H ����",
            "125"=>"H ����",
            "126"=>"H ����",
            "129"=>"H ����",
            "116"=>"H ������",
            "122"=>"J ����",
            "120"=>"J ����",
            "115"=>"J ����",
            "114"=>"L ����",
            "132"=>"N ����",
            "113"=>"N ���ɹ�",
            "133"=>"Q �ຣ",
            "118"=>"S ɽ��",
            "112"=>"S ɽ��",
            "130"=>"S ����",
            "136"=>"S �Ĵ�",
            "139"=>"X ����",
            "134"=>"X �½�",
            "138"=>"Y ����",
            "121"=>"Z �㽭",
            "140"=>"X ���",
            "141"=>"A ����",
            "142"=>"T ̨��",
        );
    }
    
    
    protected function repInnerLink($links, $innerCatalog)
    {
        //����innercatalog
        $idata = null;
        foreach ($innerCatalog as $key => $value)
        {
            if (!empty($value->path))
            {
                $value->catalog_name = trim($value->catalog_name);
                if (FALSE === strpos($value->path, 'http:'))
                {
                    $idata[$value->catalog_name] = SITE_URL . substr($this->_conf['path_inside_page'], 1) . '/' . $value->path . '/';
                } else
                {
                    $idata[$value->catalog_name] = $value->path;
                }
            }
        }

        //��վ��catalog��link,�ĸ�����ӵ�link
        $kid=array(123,124,125,126);
        $sid=array(103,104,105,106);
        
        //�õ���Ҫ�滻���ӵķ���id
        $karr = array();
        foreach ($kid as $kv)
        {
            $kvarr = $this->getChildCatalogId($kv);
            $kvarr = array_values($kvarr);
            
            if (!empty($kvarr))
            {
                foreach ($kvarr as $kva=>$vva)
                {
                    if (!empty($idata[$vva['catalog_name']]))
                    {
                        $karr[$vva['id']] = $idata[$vva['catalog_name']];
                    }
                }
            }
        }
        
        if(!empty($karr))
        {
            foreach ($karr as $kid => $kurl)
            {
                if (!empty($links[$kid]))
                {
                    $links[$kid]['url'] = $kurl;
                }
            }
        }
        
        
        //�滻��������
        foreach ($sid as $vs)
        {
            if (!empty($links[$vs]['data']))
            {
                foreach ($links[$vs]['data'] as $ks => $vvs)
                {
                    if(!empty($idata[$vvs['title']]))
                    {
                        $links[$vs]['data'][$ks]['link'] = $idata[$vvs['title']];
                    }
                }
            }
        }

        return $links;
    }

}