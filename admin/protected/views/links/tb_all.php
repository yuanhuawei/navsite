<?php $this->renderPartial('/_common/header'); ?>
<div class="wrap">
    <div class="container">
        <div id="main">
            
            <div class="con box-green">
                <?php $form = $this->beginWidget('CActiveForm',array('id'=>'tbdataform','action'=>$this->createUrl('links/tbAll'))); ?>
                <input type="hidden" name="" value="" id="tbdata" />

                <div class="box-header">
                    <h4>ѡ��Ҫͬ������ҳ���� : </h4>
                    <input type="radio" value="0" name="old" <?php if(!in_array('old', $crondArr)):echo 'checked';endif;?>/>��Ч�������� &nbsp;&nbsp; 
                    <input type="radio" value="1" name="old" <?php if(in_array('old', $crondArr)):echo 'checked';endif;?>/>ɾ��������
                    <ul>
                    <?php if(!empty($catalog)): foreach ($catalog as $cid=>$type):?>
                        <li style="display:inline;float: left;"><strong><a target="_blank" href="<?php echo $this->createUrl('links/index',array('catalogId'=>$cid))?>" ><?php echo $cid?></a></strong> : <?php echo $type?>&nbsp;&nbsp;&nbsp;</li>
                    <?php endforeach; endif;?>
                    </ul>
                </div>

                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <td>
                                <div style=" padding-left:480px">
                                    <input type="checkbox" name='check[header]' <?php if(in_array('header', $crondArr)):echo 'checked';endif;?>/>
                                    <button type="button" name='make[header]' onclick="Make(this.name)" class="button-02" >ͬ��ͷ��</button><br /><br />

                                    <input type="checkbox" name='check[left]' <?php if(in_array('left', $crondArr)):echo 'checked';endif;?> />
                                    <button type="button" name='make[left]' onclick="Make(this.name)"  class="button-02" >ͬ�������</button><br /><br />

                                    <input type="checkbox" name='check[main]' <?php if(in_array('main', $crondArr)):echo 'checked';endif;?> />
                                    <button type="button" name='make[main]' onclick="Make(this.name)" class="button-02" >ͬ��������</button><br /><br />

                                    <input type="checkbox" name='check[games]' <?php if(in_array('games', $crondArr)):echo 'checked';endif;?> />
                                    <button type="button" name='make[games]' onclick="Make(this.name)" class="button-02" >ͬ������Ϸ��</button><br /><br />
                                    
                                    <input type="checkbox" name='check[shop]' <?php if(in_array('shop', $crondArr)):echo 'checked';endif;?> />
                                    <button type="button" name='make[shop]' onclick="Make(this.name)" class="button-02" >ͬ��������</button><br /><br />

                                    <input type="checkbox" name='check[fun]' <?php if(in_array('fun', $crondArr)):echo 'checked';endif;?> />
                                    <button type="button" name='make[fun]' onclick="Make(this.name)"  class="button-02" >ͬ������������</button><br /><br />

                                    <input type="checkbox" name='check[tools]' <?php if(in_array('tools', $crondArr)):echo 'checked';endif;?> />
                                    <button type="button" name='make[tools]' onclick="Make(this.name)"  class="button-02" >ͬ��������</button><br /><br />
                                    
                                    <button type="button" name='make[crond]' onclick="Make(this.name)"  class="" >����Crond��ַ</button> ע:����վ�����ô�cron<br /><br />
                                    <?php
                                    if(!empty($this->_conf['is_cron'])):?>
                                    <div>Crond��ַΪ: <b><?php echo SITE_BACKEND_URL.'crond.php'?></b></div>
                                    <?php else:?>
                                    <div>��δ��Cron</div>
                                    <?php endif;?>
                                    </div>
                                    <script type="text/javascript">
                                            function Make(name) {
                                                var tbdata = document.getElementById('tbdata');
                                                var form = document.getElementById('tbdataform');
                                                tbdata.name = name;
                                                tbdata.value = 1;
                                                form.submit();
                                            }
                                    </script>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php $this->endWidget();?>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
</div><!--/ wrap-->
<?php $this->renderPartial('/_common/footer'); ?>
