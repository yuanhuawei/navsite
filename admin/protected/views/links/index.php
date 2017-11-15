<?php $this->renderPartial('/_common/header'); ?>
<div class="wrap">
    <div class="container">

        <div id="main">

            <div class="con">
                <form action="" method="get">
                    <input type="hidden" name="r" value="<?php echo $this->id . '/' . $this->action->id ?>" />
                    <?php if (!empty($catalogId)): ?><input type="hidden" name="catalogId" value="<?php echo $catalogId ?>" /><?php endif; ?>
                    <div class="table">
                        <div class="th">
                            <select id="alltopic" onchange="window.location = '?r=links/index&catalogId=' + this.value + ''">
                                <option value='' ></option>
                                <option value='0' <?php if (isset($catalogId) && $catalogId == 0): ?>selected<?php endif; ?>>==���з���==</option>
                                <?php foreach ($catalogList as $info): ?>
                                <option <?php if (!empty($catalogId) && $catalogId == $info['id']): ?>selected<?php endif; ?>  value='<?php echo $info['id'] ?>' ><?php echo str_replace('&nbsp;&nbsp;', '-', $info['str_repeat']) . ' ' . $info['catalog_name'] ?></option>
                                <?php endforeach; ?>
                            </select>&nbsp;

                            վ������: <input type="text" value="<?php if (!empty($keyword)): ?><?php echo $keyword; ?><?php endif; ?>" id="keyword" name="keyword"/>
                            <select name="search_type">
                                <option value="title">����</option>
                                <option value="link" <?php if (!empty($search_type) && $search_type == 'link'): ?>selected<?php endif; ?> >��ַ</option>
                            </select>
                            <input type="submit" value="����" />
                            &nbsp;&nbsp;<a href="<?php echo $this->createUrl('links/index',array('show'=>'status_n','catalogId'=>$catalogId))?>">�鿴��Чվ��</a>
                            &nbsp;&nbsp;<a href="<?php echo $this->createUrl('links/index',array('show'=>'past','catalogId'=>$catalogId))?>">�鿴��Ч���ѹ���վ��</a>
                        </div>
                    </div>
                </form>

                <?php $form = $this->beginWidget('CActiveForm', array('action' => $this->createUrl('batch'))); ?>
                <div class="table">
                    <div class="th">
                        <div class="form fl">
                            <?php if(!empty($catalogList[$catalogId]['last'])):?>
                            <a href="<?php echo $this->createUrl('create',array('catalogId'=>$catalogId))?>"><input value="���һ������" type="button" /></a>&nbsp;
                            <a href="<?php echo $this->createUrl('createBatch',array('catalogId'=>$catalogId))?>"><input value="��Ӷ�������" type="button" /></a>&nbsp;
                            <a href="<?php echo $this->createUrl('createImport',array('catalogId'=>$catalogId))?>"><input value="��������" type="button" /></a>
                                    
                                    <?php endif;?>
                        </div>
                    </div>
                    <table class="admin-tb" id="js_data_source">
                        <tr>
                            <th width="55" class="text-center"><input type="checkbox" id="chkall" onClick="checkAll(this.form, 'id')" />
                                <label for="chkall">ȫѡ</label></th>    
                            <th width="90">��Ч��</th>    
                            <th width="140">����</th>
                            <th width="40">����</th>
                            <th width="110">���ͬ��������</th>            	
                            <th width="100">������</th>
                            <th width="120">��ַ</th>
                            <th width="80">ͼƬ</th>
                            <th width="30">����</th>   
                            <th width="70">�༭ʱ��</th>   
                            <th width="40">�����</th>                            
                            <th width="40">ɾ��</th>                            
                        </tr>
                        <?php foreach ($datalist as $row): ?>
                            <tr>
                                <td class="text-center"><input type="checkbox" name="id[]" value="<?php echo $row->id ?>">&nbsp;<?php echo $row->id;?></td>
                                <td class="text-center">
                                    
                                    <input type="radio" name="status[<?php echo $row->id ?>]" value="Y" <?php if ($row->status_is == 'Y'): ?>checked="checked" <?php endif; ?>/><span class="icon_true"></span>
                                        &nbsp;&nbsp;
                                    <input type="radio" name="status[<?php echo $row->id ?>]" value="N" <?php if ($row->status_is == 'N'): ?>checked="checked"<?php endif; ?> /><span class="icon_false"></span> 
                                    <?php if(!((time()>$row->begin_time && time()<$row->end_time) || ($row->begin_time==0 && $row->end_time==0))):?>
                                    &nbsp;&nbsp;<span class="icon_light"></span>
                                    <?php endif;?>
                                </td>
                                <td><a href="<?php echo $this->createUrl('catalog/update',array('id'=>$row->catalog_id))?>" target="_blank"><?php echo $row->catalog->catalog_name ?></a></td>
                                <td><a class="overlay" href='<?php echo $this->createUrl('update',array('id'=>$row->id));?>'><span class="icon_edit" ></span></a></td>
                                <td>
                                    <a class="overlay" href='<?php echo $this->createUrl('links/create',array('catalogId'=>$row->catalog_id)) ?>'>��һ</a>&nbsp;|&nbsp;
                                    <a class="overlay" href='<?php echo $this->createUrl('links/createBatch',array('catalogId'=>$row->catalog_id)) ?>'>����</a>&nbsp;|&nbsp;
                                    <a class="overlay" href='<?php echo $this->createUrl('links/createImport',array('catalogId'=>$row->catalog_id)) ?>'>����</a>
                                </td>
                                <td><input <?php if(!empty($row->title_color)):?>style="color: #<?php echo $row->title_color?>"<?php endif;?> name="title[<?php echo $row->id ?>]" class="textinput w120" type="text" title="<?php echo $row->title?>" value="<?php echo $row->title?>"/></td>                 
                                <td><input name="link[<?php echo $row->id ?>]" class="textinput w120" title="<?php echo $row->link?>" type="text" value="<?php echo $row->link?>"/></td>                 
                                <td><input name="img_link[<?php echo $row->id ?>]" class="textinput w120" type="text" value="<?php echo $row->image_link?>" title="<?php echo $row->image_link?>"/></td>                 
                                <td><input name="sort_order[<?php echo $row->id ?>]" class="textinput w30" type="text" value="<?php echo $row->sort_order?>"/></td>
                                <td><?php if($row->create_time>0): echo date('Y-m-d',$row->create_time); endif; ?></td>
                                <td><?php if(!empty($row->user->username)):echo $row->user->username; endif;?> </td>
                                <td>
                                    <a href="<?php echo $this->createUrl('links/delete',array('id'=>$row->id))?>" class="confirmSubmit"><span class="icon_del"></span></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="foot-ctrl">
                        </tr>
                    </table>
                    <div class="th">
                        <div class="cuspages right">
                            <?php $this->widget('CLinkPager', array('pages' => $pagebar,'header'=>'�ܼ� '.$pagecount.' ��  ')); ?>
                        </div>              
                        <div class="form">
                            <input value="����ɾ��" type="submit" name='del'/>&nbsp;
                            <input value="�����޸�" type="submit" name="upd"/>&nbsp;
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
</div><!--/ wrap-->
<?php $this->renderPartial('/_common/footer'); ?>
