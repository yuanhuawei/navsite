<?php $form = $this->beginWidget('CActiveForm', array('htmlOptions' => array('enctype' => 'multipart/form-data'))); ?>
<?php echo $form->hiddenField($model, 'id');?>
<div class="box-content">
    <table class="table-font">
        <tr>
            <th  style="vertical-align:top;">���ࣺ</th>
            <td>
                <select id="alltopic" name='Links[catalog_id]'>
                    <option value='0' <?php if (empty($catalogId) || $catalogId == 0): ?>selected<?php endif; ?>>==���з���==</option>
                    <?php foreach ($this->_catalog as $info): ?>
                        <option <?php if (!empty($catalogId) && $catalogId == $info['id']): ?>selected<?php endif; ?> <?php if (empty($info['last'])): ?>disabled<?php endif; ?> value='<?php echo $info['id'] ?>' <?php if (!empty($catalogId) && $info['id'] == $catalogId): ?>selected="selected"<?php endif; ?>><?php echo str_replace('&nbsp;&nbsp;', '-', $info['str_repeat']) . ' ' . $info['catalog_name'] ?></option>
                    <?php endforeach; ?>
                </select>&nbsp;
                <?php echo $form->error($model, 'catalog_id'); ?>
            </td>
        </tr>                        
        <tr>
            <th class="w120">��������</th>
            <td>
                <?php echo $form->textField($model, 'title', array('class' => 'textinput w80')); ?>
                &nbsp;&nbsp;
         <input name="Links[title_color]" class="color" value="<?php if(empty($model->title_color)): echo '000'; else: echo $model->title_color; endif;?>" size="8">������ɫ
                <?php echo '<br />'.$form->error($model, 'title'); ?>
            </td>
        </tr>
        <tr>
            <th>���ӣ�</th>
            <td>
                <?php echo $form->textField($model, 'link', array('size' => 60, 'maxlength' => 128, 'class' => 'validate[required] textinput w270')); ?>
            <?php echo $form->error($model, 'link'); ?>
            </td>
        </tr>
        <tr>
            <th>ͼƬ��</th>
            <td>
                <label><input type="radio" name="imgtype" value="outer" <?php if(empty($model->image_link) || !(FALSE === strpos($model->image_link,'http://'))):?>checked<?php endif;?> /></label>
                ����ͼƬ : <input name="Links[image_link]" type="text" id="attach" class='textinput w270' value='<?php if(!empty($model->image_link) && !(FALSE === strpos($model->image_link,'http://'))):?><?php echo $model->image_link?><?php endif;?>'/>
                &nbsp;����<br />
                <label><input type="radio" name="imgtype" value="local"<?php if(!empty($model->image_link) && FALSE === strpos($model->image_link,'http://')):?>checked<?php endif;?>/></label>
                ����ͼƬ : <input name="image_link" type="file" id="attach" />
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
            <th>������1��</th>
            <td>
                <?php echo $form->textField($model, 'opt_a', array('size' => 60, 'maxlength' => 128, 'class' => 'textinput w270')); ?>
            </td>
        </tr>
        <tr>
            <th>������2��</th>
            <td>
                <?php echo $form->textField($model, 'opt_b', array('size' => 60, 'maxlength' => 128, 'class' => 'textinput w270')); ?>
            </td>
        </tr>
        <tr>
            <th>������3��</th>
            <td>
                <?php echo $form->textField($model, 'opt_c', array('size' => 60, 'maxlength' => 128, 'class' => 'textinput w270')); ?>
            </td>
        </tr>
        <tr>
            <th>������룺</th>
            <td>
                <textarea name="Links[mix]" id="Links_mix" class='w270'><?php if(!empty($model->mix)): echo XUtils::b64decode($model->mix); endif;?></textarea>
            </td>
        </tr>
        <tr>
            <th>��ʼʱ�䣺</th>
            <td>
                <input class="textinput w80" id="begin_time" name="Links[begin_time]" type="text" value="<?php if(!empty($model->begin_time)): echo date('Y-m-d',$model->begin_time); endif;?>" />
            </td>
        </tr>
        <tr>
            <th>����ʱ�䣺</th>
            <td>
                <input class="textinput w80" id="end_time" name="Links[end_time]" type="text" value="<?php if(!empty($model->end_time)): echo date('Y-m-d',$model->end_time); endif;?>" />
            </td>
        </tr>
        <tr>
            <th>����</th>
            <td>
                <?php echo $form->textField($model, 'sort_order', array('class' => 'textinput w80')); ?>
            </td>
        </tr>
        <tr>
            <th>��Ч�ԣ�</th>
            <td>
                <?php echo $form->dropDownList($model, 'status_is', array('Y' => '��Ч', 'N' => '��Ч')); ?>
            </td>
        </tr>
    </table>
</div>
<div class="box-footer">
    <div class="box-footer-inner">
        <input type="submit" value="�ύ" /> 
    �� <a href="<?php echo Yii::app()->request->urlReferrer; ?>">ȡ��</a>
    </div>
</div>
<?php $this->endWidget(); ?>

<link href="<?php echo STATIC_BACKEND_URL ?>datapicker/css/jquery-ui-1.7.1.custom.css" rel="stylesheet" type="text/css"  />
<script type="text/javascript" src="<?php echo STATIC_BACKEND_URL ?>datapicker/ui.core.js"></script>
<script type="text/javascript" src="<?php echo STATIC_BACKEND_URL ?>datapicker/jquery-ui-1.7.1.custom.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_BACKEND_URL ?>jscolor/jscolor.js"></script>
<script>
        jQuery(function($) {

            $("#begin_time").datepicker();
            $("#end_time").datepicker();

        });
</script>
