<?php $this->renderPartial('/_common/header'); ?>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con box-green">
                <?php $form = $this->beginWidget('CActiveForm'); ?>
                    <div class="table">
                        <div class="th">
                            <div class="form">
                            </div>
                        </div>
                        <style type="text/css">
                            table.admin-tb tr:hover { background-color:#FFFFCC;}
                        </style>
                        <div class="box-header">
                            <h4>����������ַ</h4>
                        </div>
                        <div class="box-content" style="padding-left:50px">
                            <p style="padding:5px;width:450px; margin:10px 0; border:1px solid #FFB340; background:#FFDAA0">
                                ֱ��ճ��html���룬������Զ�ƥ����ַ , һ����ദ��300��
                            </p>

                            <textarea name='Links[sites]' style="width:450px; height:300px; font-family:Arial, Helvetica, sans-serif"></textarea>
                        </div>
                        <div class="box-content clearfix" style="padding-left:50px">
                            <div id="classSearch" class="fl ml5" style="_margin-top:-6px;">
                                ����ͼƬ���ӣ�<input type="checkbox" name="doimg" value="1" /> &nbsp; ע: �����ʹ��,ͼƬ��������������������˳�������������ͬ,������Ч;
                            </div>
                        <div style="clear:both"></div>
                        </div>
                        <div class="box-content clearfix" style="padding-left:50px">
                            <div id="classSearch" class="fl ml5" style="_margin-top:-6px;">
                                ���
                                <select id="alltopic" name='Links[catalog_id]'>
                                    <option value='0' <?php if (empty($catalogId) || $catalogId == 0): ?>selected<?php endif; ?>>==���з���==</option>
                                    <?php foreach ($this->_catalog as $info): ?>
                                        <option <?php if (!empty($catalogId) && $catalogId == $info['id']): ?>selected<?php endif; ?> <?php if (empty($info['last'])): ?>disabled<?php endif; ?> value='<?php echo $info['id'] ?>' <?php if (!empty($catalogId) && $info['id'] == $catalogId): ?>selected="selected"<?php endif; ?>><?php echo str_replace('&nbsp;&nbsp;', '-', $info['str_repeat']) . ' ' . $info['catalog_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>&nbsp;
                                <?php echo $form->error($model, 'catalog_id'); ?>
                            </div>
                            <div style="clear:both"><br /></div>
                            <br />
                            <br />

                        </div>
                        <div class="th">
                            <div class="form">
                                <div class="fl">
                                    <input type="submit" value="ȷ��" />
                                </div>
                            </div>
                        </div>
                    </div>
                <?php $this->endWidget(); ?>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
</div><!--/ wrap-->
<?php $this->renderPartial('/_common/footer'); ?>
