<!DOCTYPE html>
<html>
 <head> 
  <meta http-equiv="Content-Type" content="text/html; charset=gbk" /> 
  <title><?php echo empty($info->seo_t)?$info->catalog_name:$info->seo_t;?></title> 
  <meta name="keywords" content="<?php echo empty($info->seo_k)?$info->catalog_name:$info->seo_k;?>" /> 
  <meta name="description" content="<?php echo empty($info->seo_d)?$info->catalog_name:$info->seo_d;?>" /> 
  <link type="text/css" rel="stylesheet" href="<?php echo STATIC_THEME_URL?>css/inner.css" /> 
  <base target="_blank" /> 
 </head> 
 <body>
  <div id="top">
   <div class="wrapper">
    <div class="fl">
     <a href="http://v.114la.com/">��Ӱ</a>
     <a href="http://game.114la.com/">��Ϸ</a>
     <a href="http://yinyue.114la.com/">����</a>
     <a href="http://book.114la.com/">С˵</a>
     <a href="http://tuan.114la.com/">�Ź�</a>
     <a href="http://tool.114la.com/">ʵ�ù���</a>
     <i class="sq">|</i>
     <a href="javascript:;" class="cates" target="_self">���ർ��<i></i></a>
    </div>
    <div class="fr">
     <a href="http://www.114la.com" class="home">114����ҳ</a>
     <i class="sq">|</i>
     <a href="http://www.114la.com/app">�ֻ���</a>
     <i class="sq">|</i>
     <a href="http://www.114la.com/feedback/">�������</a>
     <i class="sq">|</i>
     <a href="javascript:;" title="114����ҳ�޸�" id="collet">�ղر�ҳ</a>
    </div>
   </div>
  </div>
  <div class="wrapper">
   <div class="categorys">
    <dl>
     <dd>
      <?php if(!empty($innerCatalog)):?>
      <?php $i=1;$c = count($innerCatalog); foreach ($innerCatalog as $v):?>
         <?php if(empty($v->path)):continue;endif?>
         <a href="<?php if(substr($v->path, 0,4) == 'http'):echo $v->path;else:echo SITE_URL.substr($this->_conf['path_inside_page'], 1) .'/'.$v->path.'/';endif;?>"><?php echo $v->catalog_name?></a>
      <?php if($i>1&& $i%15==0 && $i<$c):?>
     </dd><dd>
      <?php endif;?>
      <?php $i++;endforeach;?>
      <?php endif;?>
     </dd>
    </dl>
   </div>
   <div class="header clearfix">
    <h1 class="logo"><a href="http://www.114la.com/" title="<?php echo $info->catalog_name?>"> <img height="31" src="<?php if(!empty($info->image_link)): if(FALSE === strpos($info->image_link, 'http:')): echo DIR_UPLOADS_URL . $info->image_link; else: echo $info->image_link; endif; else: echo COMMON_IMG_URL.'logo_inner.png'; endif;?>" alt="<?php echo $info->catalog_name?>" /></a></h1> 
    <ul class="searKeyWord">
     <li><a href="http://v.114la.com/">��Ӱ</a></li>
     <li><a href="http://game.114la.com/">��Ϸ</a></li>
     <li><a href="http://yinyue.114la.com/">����</a></li>
     <li><a href="http://book.114la.com/">С˵</a></li>
     <li><a href="http://tuan.114la.com/">�Ź�</a></li>
    </ul>
    <div class="searcha">
     <form id="searForm" action="http://www.baidu.com/s" method="get" target="_blank">
      <span>�ٶ�<i></i></span>
      <ul>
       <li rel="baidu">�ٶ�</li>
       <li rel="sogou">�ѹ�</li>
      </ul>
      <input id="innerTxt" type="text" value="" name="wd" />
      <button type="submit">����</button>
      <input type="hidden" name="tn" value="hkxs_1_pg" />
      <input type="hidden" name="ch" value="4" />
      <input type="hidden" name="ie" value="utf-8" />
     </form>
    </div>
   </div> 
   <div class="comRowGuid"> 
<?php if(!empty($links)): $i = count($links); foreach($links as $kc =>$vc):?> 
    <dl class="">
   <dt>
    <a><?php echo $vc['name']?></a>
   </dt>
   <dd>
    <table>
     <tbody>
      <tr> 
          <?php if(!empty($vc['data'])): $m=1;$a=count($vc['data']); foreach($vc['data'] as $kd =>$vd):?> 
       <td><?php if(empty($vd['mix'])):?>
           <a <?php if(!empty($vd['title_color'])):?> style="color:#<?php echo $vd['title_color']?>;"<?php endif;?> class="<?php if(!empty($vd['opt_a'])):echo $vd['opt_a'];endif;?>" href="<?php echo $vd['link']?>"><?php echo $vd['title']?></a>
        <?php else: echo XUtils::b64decode($vd['mix'])?>
        <?php endif;?>
       </td><?php if($m>0 && $m%6==0 && $m<$a):?></tr><tr><?php endif;?>
       <?php $m++; endforeach; endif;?> 
      </tr>
      <tr> 
      </tr>
     </tbody>
    </table>
   </dd>
  </dl>
           <?php if($i>1):?> 
    <div class="shr"></div> 
    <?php endif;?> 
       <?php $i--; endforeach; endif;?> 

   </div> 
   <div class="line"></div>
  </div>
  <div id="footer">
   <div class="wrapper">
    <dl>
     <dt>
      ����Ƶ��
     </dt>
     <dd>
      <a href="http://game.114la.com/" target="_blank">��Ϸ��ȫ</a> 
      <a href="http://v.114la.com/tv/" target="_blank">�Ȳ�����</a> 
      <a href="http://book.114la.com/" target="_blank">����С˵</a>
      <a href="http://manhua.114la.com/" target="_blank">��������</a>
      <br />
      <a href="http://tuan.114la.com/" target="_blank">��Ʒ�Ź�</a> 
      <a href="http://v.114la.com/movie/" target="_blank">���µ�Ӱ</a> 
      <a href="http://www.114la.com/mm/index.htm" target="_blank">��ŮͼƬ</a>
      <a href="http://yinyue.114la.com/" target="_blank">��������</a>
     </dd>
    </dl>
    <dl>
     <dt>
      �������
     </dt>
     <dd> 
      <a href="http://tianqi.114la.com/" target="_blank">����Ԥ��</a> 
      <a href="http://www.114la.com/caijinggushi/" target="_blank">��Ʊ��ѯ</a> 
      <a href="http://yingyong.114la.com/" target="_blank">�ֻ�Ӧ��</a> 
      <a href="http://tool.114la.com/live/calendar/" target="_blank">������</a>
      <br />
      <a href="http://car.114la.com/index.html" target="_blank">��������</a> 
      <a href="http://tool.114la.com/live/express/" target="_blank">��ݲ�ѯ</a> 
      <a href="http://tool.114la.com/live/calendar/" target="_blank">���߷���</a> 
      <a href="http://app.114la.com/chartcode/" target="_blank">��ά��</a>
     </dd>
    </dl>
    <dl>
     <dt>
      ʵ�ù���
     </dt>
     <dd>
      <a href="http://tool.114la.com/live/speed/">���ٲ���</a>
      <a href="http://tool.114la.com/live/caipiao/">��Ʊ��ѯ</a>
      <a href="http://tool.114la.com/live/nongli/">�Ƶ�����</a>
      <a href="http://app.114la.com/zhibo/">����ֱ��</a>
      <br />
      <a href="http://tool.114la.com/finance/rate/">���ʲ�ѯ</a>
      <a href="http://tool.114la.com/youbian/">�ʱ��ѯ</a>
      <a href="http://tool.114la.com/live/chepai/">���Ʋ�ѯ</a>
      <a href="http://tool.114la.com/site/gb2big/">�򷱻���</a>
     </dd>
    </dl>
    <p class="btmlink">
        <span class="fr">&copy;2005-<script type="text/javascript">document.write(new Date().getFullYear());</script>&nbsp;
            <a target="_self" href="<?php echo SITE_URL?>"><?php echo $this->_conf['site_name'];?></a>&nbsp;
            <a href="<?php echo $this->_conf['site_icp_url'];?>"><?php echo $this->_conf['site_icp'];?></a></span></p>
   </div>
  </div>
  <div id="costom">
   <a href="#" id="gotop">�ص�����</a>
   <a href="javascript:void(0)" onclick="divcenter()" id="feedback" target="_parent">�������</a>
  </div>
     
  <script src="<?php echo COMMON_JS_URL?>jquery-1.7.2.min.js"></script>
  <script src="<?php echo STATIC_THEME_URL?>js/jquery.bxslider.min.js"></script>
  <script src="<?php echo STATIC_THEME_URL?>js/fiction_common.js"></script>
     
  <div style="display:none">
   <?php if(!empty($this->_conf['site_stats'])):?><?php echo $this->_conf['site_stats']?><?php endif;?>
  </div> 
 
 </body>
</html>