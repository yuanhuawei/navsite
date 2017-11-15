<?php $form = $this->beginWidget('CActiveForm'); ?>
    <div class="box-content">
        <table class="table-font">
            <tr>
                <th class="w120">�˺ţ�</th>
                <td>
                    <?php echo $form->textField($model, 'username', array('class' => 'textinput')); ?>
                    <?php echo $form->error($model, 'username'); ?>
                </td>
            </tr>
            <tr>
                <th><?php if (!empty($model->id)):?>��<?php endif;?>���룺</th>
                <td>
                    <input name="Admin[password]" type="password" class="textinput" autocomplete="off"/> <?php if (!empty($model->id)):?>������������<?php endif;?>
                </td>
            </tr>
            
            <tr>
                <th>ȷ��<?php if (!empty($model->id)):?>��<?php endif;?>���룺</th>
                <td>
                    <input name="Admin[password2]" type="password" class="textinput" autocomplete="off"/> <?php if (!empty($model->id)):?>������������<?php endif;?>
                    <?php echo $form->error($model, 'password'); ?>
                </td>
            </tr>
            <tr>
                <th class="w120">�û���</th>
                <td>
                    <?php echo $form->textField($model, 'realname', array('class' => 'textinput')); ?>
                    <?php echo $form->error($model, 'realname'); ?>
                </td>
            </tr>
            
            <tr>
                <th>�����飺</th>
                <td>
                    <?php if($model->id==1):?>
                    ���������� <?php echo $form->hiddenField($model,'group_id')?>
                    <?php else:?>
                    <select name="Admin[group_id]">
                        <option ></option>
                        <?php foreach ($group as $v):?>
                        <option value="<?php echo $v['id']?>" <?php if(!empty($model->group_id) && $model->group_id == $v['id']): echo 'selected'; endif;?>><?php echo $v['group_name']?></option>
                        <?php endforeach;?>
                    </select>
                    <?php echo $form->error($model, 'group_id'); ?>
                    <?php endif;?>
                </td>
            </tr>
            
        </table>
        
    </div>
            
    <div class="box-footer">
        <div class="box-footer-inner">
            <?php if (!empty($model->id)):?>
            <input type="hidden" value="<?php echo $model->id?>"/>    
            <?php endif;?>
            <input type="submit" value="�ύ" /> �� <input type="reset" value="���"/>
        </div>
    </div>
<?php $this->endWidget(); ?>
