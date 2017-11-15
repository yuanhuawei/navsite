<?php $this->renderPartial('/_common/header'); ?>
<div class="wrap">
    <div class="container">

        <div id="main">

            <div class="con ">
                <form action="" method="post">
                    <div class="table">
                        <div class="th">
                            <div class="form">
                                <a href="<?php echo $this->createUrl('groupCreate') ?>"><input type="button" value="����¹�����" /></a></div>
                        </div>
                        <table class="admin-tb" id="tb1">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="20%">�û��� </th>
                                <th width="15%">¼��ʱ��</th>
                                <th>����</th>
                            </tr>
                            <?php foreach ($datalist as $row): ?>
                                        <tr>  <!-- <tr class="checked">Ĭ��ѡ�� -->
                                    <td >
                                        <?php echo $row['id'] ?></td>
                                    <td ><?php echo $row['group_name'] ?></td>
                                    <td ><?php echo date('Y-m-d H:i', $row['create_time']) ?></td>
                                    <td >
                                        <?php if (!in_array($row['id'], array(1, 2))): ?>
                                            <a class="icon_edit" href="<?php echo $this->createUrl('groupUpdate', array('id' => $row['id'],'name'=>$row['group_name'])) ?>">�༭Ȩ��</a>&nbsp;&nbsp;
                                            <a class="icon_del" href="<?php echo $this->createUrl('groupDelete', array('id' => $row['id'])) ?>" class="confirmSubmit re" rel="ɾ��������,�������й����˺Ž�������,�Ƿ�ȷ��?">ɾ��</a>
                                        <?php else: ?>
                                            ϵͳ��
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="foot-ctrl">
                            </tr>
                        </table>

                        <div class="th"><!--/ pages-->


                            <div class="form">
                                <input name="�ύ" type="submit" value="ɾ ��" />
                            </div>
                        </div>
                    </div>
                </form>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
</div><!--/ wrap-->              

<?php $this->renderPartial('/_common/footer'); ?>
