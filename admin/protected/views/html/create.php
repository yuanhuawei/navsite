<?php $this->renderPartial('/_common/header'); ?>
<div class="wrap">
    <div class="container">
        <div id="main">
            
            <div class="con box-green">
                <?php $form = $this->beginWidget('CActiveForm',array('id'=>'makehtmlform','action'=>$this->createUrl('html/create'))); ?>
                    <input type="hidden" name="" value="" id="makehtml" />
                <div class="box-header">
                    <h4>��ǰ����ҳ��ı���ΪGBK,ѡ��Ҫ���ɵ�ҳ��(������.html��.htm)</h4>
                    <ul>
                    <?php if(!empty($page_arr)): foreach ($page_arr as $info): if(empty($info['error'])):?>
                        <li style="display:inline;float: left;"><strong><?php echo $info['name']?></strong> �ɹ� : <strong><a href="<?php echo SITE_URL?><?php if(!empty($info['path'])): echo substr($this->_conf['path_inside_page'], 1) .'/'.$info['path']; endif;?>" target="blank"><?php if(!empty($info['path'])): echo $info['path']; else: echo 'index.html'; endif;?></a></strong> &nbsp;&nbsp;&nbsp;</li>
                    <?php else:?>
                        <li style="display:inline;float: left;"><strong><?php echo $info['name']?></strong> <font color="red">ʧ��</font> :  <?php echo $info['error']?>  &nbsp;&nbsp;&nbsp;</li>
                    <?php endif; endforeach; endif;?>
                    </ul>
                </div>

                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <td>
                                <div style=" padding-left:480px">

                                    <button type="button" name='make[index]' onclick="Make(this.name)" class="button-02" >������ҳ</button><br /><br />

                                    <button type="button" name='make[inner]' onclick="Make(this.name)"  class="button-02" >�������ݷ���ҳ��</button><br /><br />

                                    <button type="button" name='make[all]' onclick="Make(this.name)"  class="button-02" >����ȫվ</button><br /><br />
                                </div>

                                <script type="text/javascript">
                                        function Make(name) {
                                            var makehtml = document.getElementById('makehtml');
                                            var form = document.getElementById('makehtmlform');
                                            makehtml.name = name;
                                            makehtml.value = 1;
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
