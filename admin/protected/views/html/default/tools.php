                                <div class="toolsCol">
                                    <div class="tilRow">
 <span class="tilTxt"><span class="tilIcon iconTool">&#xe60e;</span><label>��ù���</label></span>
 <a href="#" class="more">����&gt;&gt;</a>
                                    </div>
                                    <?php $cArr = $this->getChildCatalogId(118); ?>
                                    <?php $mm=1;foreach ($cArr as $i =>$v): if($mm>1):break;endif;?>
                                    <div class="colLeft">
 <ul>
 <?php if(!empty($x[$i]['data'])): ?>
 <?php foreach ($x[$i]['data'] as  $k => $item): ?>
 <li>
<?php if(empty($item['mix'])): ?>
<a class="<?php echo $item['opt_a'];?>" <?php if(!empty($item['title_color'])):?> style="color:#<?php echo $item['title_color']?>;"<?php endif;?> href="<?php echo $item['link']; ?>"></a> 
<?php else: ?>
<?php echo XUtils::b64decode($item['mix']); ?>
<?php endif; ?>
 </li>
 <?php endforeach; ?>
 <?php endif; ?>
 </ul>
                                    </div>
                                    <?php $mm++; endforeach;?>
                                    
                                    <?php $mm=1;foreach ($cArr as $i =>$v): if($mm==2):?>
                                    <div class="colRight">
<ul class="clearfix" >
<?php if(!empty($x[$i]['data'])): ?>
<?php $z=1;foreach ($x[$i]['data'] as  $k => $item): ?>
<li>
<?php if(empty($item['mix'])): ?>
<a <?php if(!empty($item['title_color'])):?> style="color:#<?php echo $item['title_color']?>;"<?php endif;?> href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a> 
<?php else: ?>
<?php echo XUtils::b64decode($item['mix']); ?>
<?php endif; ?>
</li>
<?php if($z==6):?> </ul><ul class="clearfix"> <?php endif;?>
 <?php $z++;endforeach; ?>
<?php endif; ?>
</ul>
                                    </div>
                                    <?php endif; $mm++; endforeach;?>
                                    
                                </div>
                                <div class="starCol">
                                    <div class="tilRow">
 <span class="tilTxt "><span class="tilIcon iconStar ">&#xe614;</span><label>����������</label></span>
 <span class="star_op"><label></label><span class="op_icon"></span></span>
                                    </div>
                                    <div class="star_chose">
 <ul>
     <li><a href="javascript:void(0)" xzid="1" target="_self">������</a></li>
     <li><a href="javascript:void(0)" xzid="2" target="_self">��ţ��</a></li>
     <li><a href="javascript:void(0)" xzid="3" target="_self">˫����</a></li>
     <li><a href="javascript:void(0)" xzid="4" target="_self">��з��</a></li>
     <li><a href="javascript:void(0)" xzid="5" target="_self">ʨ����</a></li>
     <li><a href="javascript:void(0)" xzid="6" target="_self">��Ů��</a></li>
     <li><a href="javascript:void(0)" xzid="7" target="_self">�����</a></li>
     <li><a href="javascript:void(0)" xzid="8" target="_self">��Ы��</a></li>
     <li><a href="javascript:void(0)" xzid="9" target="_self">������</a></li>
     <li><a href="javascript:void(0)" xzid="10" target="_self">Ħ����</a></li>
     <li><a href="javascript:void(0)" xzid="11" target="_self">ˮƿ��</a></li>
     <li><a href="javascript:void(0)" xzid="12" target="_self">˫����</a></li>
 </ul>
                                    </div>
                                    <div class="starCom">
         <?php if(!empty($x[119]['data'][0]['mix'])): ?>
         <?php $mix = json_decode(XUtils::b64decode($x[119]['data'][0]['mix']),1);?>
 <div class="starRow1">
     <span class="starAdv">
<a href="<?php echo $mix['url'];?>">
    <img src="<?php echo STATIC_THEME_URL?>images/xingzuo/tupian<?php echo $x[119]['data'][0]['opt_a']?>.jpg" />
</a>
     </span>
     <div class="starTxt1">
<div class="txt1Row">
    <span><?php echo $mix['astro']?>(<?php echo $mix['date']?>)</span>
    &nbsp;&nbsp;&nbsp;
    <?php   
    $g = ceil($mix['general']/20);
    for ($i=1;$i<=$g;$i++):?><span class="sartIco"></span> <?php endfor;
    for ($i=1;$i<=5-$g;$i++):?><span class="sartIco sartIco-h"></span><?php endfor;?>
    &nbsp;&nbsp;&nbsp;
    <span class="star_yun">
    <?php
    switch ($g):
        case 5:$g = '����';break;
        case 4:$g = '����';break;
        case 3:$g = 'ƽƽ';break;
        case 2:$g = '����';break;
        case 1:$g = '���';break;
    endswitch;
    echo $g;
    ?>
    </span>
    <span class=""></span>
</div>

<div class="txt1Row2">
    <a href="<?php $mix['url']?>#today">������</a><a href="<?php $mix['url']?>#week">������</a><a href="<?php $mix['url']?>#mouth">������</a>
</div>
     </div>
 </div>
 
 <div class="starRow2">
     <div class="starDRow">
<span class="gray">������ɫ��</span><em><?php $mix['color']?></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="gray">�������֣�</span><em>2</em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="gray">����������</span><em>������</em>
     </div>
     <div class="starDRow">
<span class="gray">����ָ����</span>
<?php $g = ceil($mix['love']/20);
    for ($i=1;$i<=$g;$i++):?><span class="sartIco"></span> <?php endfor;
    for ($i=1;$i<=5-$g;$i++):?><span class="sartIco sartIco-h"></span><?php endfor;?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="gray">����ָ����</span>
<?php $g = ceil($mix['work']/20);
    for ($i=1;$i<=$g;$i++):?><span class="sartIco"></span> <?php endfor;
    for ($i=1;$i<=5-$g;$i++):?><span class="sartIco sartIco-h"></span><?php endfor;?>
     </div>
     <div class="starDRow">
<span class="gray">����ָ����</span>
<span class="sartIco"></span>
<?php $g = ceil($mix['money']/20);
    for ($i=1;$i<=$g;$i++):?><span class="sartIco"></span> <?php endfor;
    for ($i=1;$i<=5-$g;$i++):?><span class="sartIco sartIco-h"></span><?php endfor;?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="gray">����ָ����</span>
<?php $g = ceil($mix['health']/20);
    for ($i=1;$i<=$g;$i++):?><span class="sartIco"></span> <?php endfor;
    for ($i=1;$i<=5-$g;$i++):?><span class="sartIco sartIco-h"></span><?php endfor;?>
     </div>
     <div class="starDRow2">
<span class="gray">���ո�����</span>
<em><?php echo $mix['description']?> </em>  
<a href="<?php $mix['url']?>" class="detail">����&gt;&gt;</a>
     </div>
 </div>
 
<?php endif;?>
                                    </div>
                                </div>
                                <div class="otherCol">
                                    <ul class="colTitle btop" id="tool-tab">
 <li rel="tb1"class="active toolTab" id="tool-tab-def"><a href="javascript:;">��Ʊ</a></li>
 <li class="toolTab" rel="tb2"><a href="javascript:;">�Ƶ�</a></li>
 <li class="toolTab" rel="tb3" ><a href="javascript:;">����</a></li>
 <li rel="tb4" ><a href="http://app.alipay.com/tx/mobile.htm" target="_blank">�ֻ�</a></li>
                                    </ul>
                                    <div class="comWrap" style="display:block;">
 <div id="tb" class="usage-con">
     <div style="display:block;" class="tbox tTicket" id="tb1">
<form onsubmit="kuxun.searchTicket();
                return false;"  class="plane">
    <p>&nbsp;�� &nbsp;
        <input type="text" onblur="this.value == '' ? this.value = '����' : this.value = this.value" onclick="(this.value == '����') ? this.value = '' : this.focus()" value="����" name="t" class="ipt-text" id="jP_startCity" />
        &nbsp;��&nbsp;
        <input type="text" onblur="this.value == '' ? this.value = '�Ϻ�' : this.value = this.value" onclick="(this.value == '�Ϻ�') ? this.value = '' : this.focus()" value="�Ϻ�" class="ipt-text" name="q" id="jP_toCity" />
    </p>
    <p class="under">����
        <input type="text" name="date" id="jp_today" class="ipt-text ipt-date" value="2012-07-15" />
        &nbsp;<span class="box-btn">
            <input type="submit" class="btn rep" value="�鿴�ۿۼ�" />
        </span></p>
</form>
     </div>
     <div style="display:none;" class="tbox tHotel" id="tb2">
<form onsubmit="kuxun.searchHotel();
                return false;" class="plane">
    <p>����&nbsp;
        <input id="ht_city" onblur="this.value == '' ? this.value = '����' : this.value = this.value" onclick="(this.value == '����') ? this.value = '' : this.focus()" value="����" class="ipt-text ipt-city" name="city" />
        &nbsp;��ס����&nbsp;
        <input  value="" id="ht_today" class="ipt-text ipt-date" name="date" />
    </p>
    <p class="under">�Ƶ�&nbsp;
        <input value="" id="ht_key" class="ipt-text" name="nameContains" />
        &nbsp;&nbsp;<span class="box-btn">
            <input type="submit" class="btn rep" value="�� ��" />
        </span></p>
</form>
     </div>
     <div style="display:none;" class="tbox tTour" id="tb3">
<form onsubmit="kuxun.searchTravel();
                return false;" class="plane">
    <p >������&nbsp;
        <input type="text" onblur="this.value == '' ? this.value = '����' : this.value = this.value" onclick="(this.value == '����') ? this.value = '' : this.focus()" value="����" name="StartPlace" class="ipt-text" id="daodao_travel_q" />
    </p>
    <p class="under">Ŀ�ĵ�&nbsp;
        <input value="" id="daodao_travel_k" class="ipt-text" name="KeyWords" />
        &nbsp;&nbsp;<span class="box-btn">
            <input type="submit" class="btn rep " value="��������" />
        </span></p>
</form>
     </div>
     
 </div>
                                    </div>

                                    <div class="phone_adv">
 <ul class="mslide appWrap">
     <li style="display:block;"><!--����-->
<?php if(!empty($x[277]['data'])): ?>
<?php foreach ($x[277]['data'] as  $k => $item): ?> 
<a class="app" href="<?php echo $item['link']?>"><img src="<?php echo $item['image_link']?>"><?php echo $item['title']?></a>
 <?php endforeach; ?>
 <?php endif; ?>
     </li>
 </ul>
                                    </div>
                                </div>