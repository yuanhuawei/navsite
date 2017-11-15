<?php $this->renderPartial('/_common/header'); ?>
<div class="wrap">
    <div class="container">

        <div id="main">

            <div class="con ">
                <form action="" method="post">
                    <div class="table">
                        <div class="th">
                            <div class="form">
                                <a href="<?php echo $this->createUrl('create')?>"><input type="button" value="������û�" /></a></div>
                        </div>
                        <table class="admin-tb" id="tb1">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">�û� </th>
                                <th width="12%">��</th>
                                <th width="10%">��ʵ����</th>
                                <th width="13%">����¼</th>
                                <th >����</th>
                            </tr>
                            <?php foreach ($datalist as $row): ?>
                                <tr>  <!-- <tr class="checked">Ĭ��ѡ�� -->
                                    <td ><?php echo $row->id ?></td>
                                    <td ><?php echo $row->username ?></td>
                                    <td ><?php echo $row->adminGroup->group_name ?></td>
                                    <td ><?php echo $row->realname ?></td>
                                    <td ><?php echo date('Y-m-d H:i', $row->last_login_time) ?></td>
                                    <td ><a class="icon_edit" href="<?php echo $this->createUrl('update', array('id' => $row->id)) ?>">�༭</a>&nbsp;&nbsp;
                                        <?php if($row->id>1):?>
                                        <a class="icon_del confirmSubmit re" href="<?php echo $this->createUrl('del', array('id' => $row->id)) ?>" >ɾ��</a></td>
                                        <?php endif;?>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="foot-ctrl">
                            </tr>
                        </table>

                        <div class="th"><!--/ pages-->
                        </div>
                    </div>
                </form>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
</div><!--/ wrap-->              

<?php $this->renderPartial('/_common/footer'); ?>
