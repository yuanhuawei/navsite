<div class="con box-green">

    <?php if (empty($id)): ?>
        <?php $form = $this->beginWidget('CActiveForm', array('action' => $this->createUrl('create'),'htmlOptions' => array('enctype' => 'multipart/form-data'))); ?>
    <?php else: ?> 
        <?php $form = $this->beginWidget('CActiveForm', array('action' => $this->createUrl('update',array('id'=>$model->id)),'htmlOptions' => array('enctype' => 'multipart/form-data'))); ?>
        <?php echo $form->hiddenField($model, 'id'); ?>
    <?php endif; ?>
    <div class="box-header">
        <h4>�༭����</h4>
    </div>
    <div class="box-content">
        <table class="table-font">
            <tr>
                <th class="w120">�������ƣ�</th>
                <td>
                    <?php echo $form->textField($model, 'catalog_name', array('class' => 'textinput w80')); ?>
                </td>
            </tr>
            <tr>
                <th>�ϲ���ࣺ</th>
                <td>
                    <select name="Catalog[parent_id]" id="Catalog_parent_id">
                        <option value="0">==��������==</option>
                        <?php foreach ($this->_catalogAll as $catalog): ?>
                            <option value="<?php echo $catalog['id'] ?>" <?php XUtils::selected($catalog['id'], $model->parent_id); ?>><?php echo $catalog['str_repeat'] ?><?php echo $catalog['catalog_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>��ʾ��Ŀ��</th>
                <td>
                    <?php echo $form->textField($model, 'data_count', array('class' => 'textinput w80')); ?>
                    <?php echo $form->error($model,'data_count');?>
                </td>
            </tr>
            <?php if(isset($model->parent_id) && $model->parent_id =='2'):?>
            <tr>
                <th>��ҳ����Ŀ¼���� / ������ַ��</th>
                <td>
                    <?php echo $form->textArea($model, 'path'); ?> 
                    <?php echo $form->error($model,'path');?>
                    ����������ҳʱʹ��,������Ŀ¼����Ĭ��Ϊ������ƴ��;
                </td>
            </tr>
            <tr>
            <th>��ҳlogo��</th>
            <td>
                <label><input type="radio" name="imgtype" value="outer" <?php if(empty($model->image_link) || !(FALSE === strpos($model->image_link,'http://'))):?>checked<?php endif;?> /></label>
                ���� : <input name="Catalog[image_link]" type="text" id="attach" class='textinput w270' value='<?php if(!empty($model->image_link) && !(FALSE === strpos($model->image_link,'http://'))):?><?php echo $model->image_link?><?php endif;?>'/>
                &nbsp;����<br />
                <label><input type="radio" name="imgtype" value="local"<?php if(!empty($model->image_link) && FALSE === strpos($model->image_link,'http://')):?>checked<?php endif;?>/></label>
                ���� : <input name="image_link" type="file" id="attach" />
                <?php if (!empty($model->image_link)): ?>
                <?php if(!empty($model->image_link) && FALSE === strpos($model->image_link,'http://')): $y = DIR_UPLOADS_URL; else: $y=null;  endif;?>
                    <a href="<?php echo $y . $model->image_link ?>" target="_blank">
                        <img src="<?php echo $y . $model->image_link ?>" width="50" align="absmiddle" />
                    </a>
                <?php endif ?>
                <span style="margin-left:10px;">����ԭͼƬ��,����ͬ��ͼƬ <input name='oldpicname' value="1" type="checkbox" />
            </td>
            </tr>
            
            <tr>
                <th>SEO���⣺</th>
                <td>
                    <?php echo $form->textField($model, 'seo_t',array('class'=>'textinput w80')); ?> 
                    <?php echo $form->error($model,'seo_t');?>
                    ����������ҳʱʹ��,������Ĭ��Ϊ������;
                </td>
            </tr>
            <tr>
                <th>SEO�ؼ��֣�</th>
                <td>
                    <?php echo $form->textField($model, 'seo_k',array('class'=>'textinput w80')); ?> 
                    <?php echo $form->error($model,'seo_k');?>
                    ����������ҳʱʹ��,������Ĭ��Ϊ������;
                </td>
            </tr>
            <tr>
                <th>SEO������</th>
                <td>
                    <?php echo $form->textArea($model, 'seo_k'); ?> 
                    <?php echo $form->error($model,'seo_k');?>
                    ����������ҳʱʹ��,������Ĭ��Ϊ������;
                </td>
            </tr>
            <?php endif;?>
            <tr>
                <th>��ת���ӣ�</th>
                <td>
                    <?php echo $form->textArea($model, 'redirect_url'); ?> 
                    <?php echo $form->error($model,'redirect_url');?>
                    ������; ���ڱ�����������'����'���ӻ��߷�������;
                </td>
            </tr>
            <tr>
                <th>ͬ��ID��</th>
                <td>
                    <?php echo $form->textField($model, 'tb_id',array('class'=>'textinput w80')); ?> 
                    <?php echo $form->error($model,'tb_id');?>
                    ����һ��ͬ�������Ӧ����;
                </td>
            </tr>
            <tr>
                <th>����1��</th>
                <td>
                    <?php echo $form->textField($model, 'opt_1',array('class'=>'textinput w80')); ?> 
                    <?php echo $form->error($model,'opt_1');?>
                    ��������1;
                </td>
            </tr>
            <tr>
                <th>����2��</th>
                <td>
                    <?php echo $form->textField($model, 'opt_2',array('class'=>'textinput w80')); ?> 
                    <?php echo $form->error($model,'opt_2');?>
                    ��������2;
                </td>
            </tr>
            <tr>
                <th>��ʾ״̬��</th>
                <td>
                    <?php echo $form->dropDownList($model, 'status_is', array('Y' => '��ʾ', 'N' => '����')); ?>
                </td>
            </tr>
            <tr>
                <th  style="vertical-align:top;">������ܣ�</th>
                <td><?php echo $form->textArea($model, 'content'); ?></td>
            </tr>

        </table>
    </div>
    <div class="box-footer">
        <div class="box-footer-inner">
            <input type="submit" value="�ύ" /> �� <input type="reset" value="����" /> �� <a href="<?php echo Yii::app()->request->urlReferrer?>">ȡ��</a>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!--/ con-->