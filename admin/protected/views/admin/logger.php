<?php $this->renderPartial('/_common/header'); ?>
<div class="wrap">
    <div class="container">

        <div id="main">

            <div class="con ">
                    <div class="table">
                        <div class="th">
                            <div class="form">
                                �˺�ѡ�� : <select id="alltopic" onchange="window.location = '?r=admin/logger&uid=' + this.value + ''">
                                <option value='0' <?php if (isset($uid) && $uid == 0): ?>selected<?php endif; ?>>==�����˺�==</option>
                                <?php foreach ($users as $info): ?>
                                    <option <?php if (!empty($uid) && $uid == $info->id): ?>selected<?php endif; ?>  value='<?php echo $info->id?>' ><?php echo $info->username?></option>
                                <?php endforeach; ?>
                            </select>&nbsp;
                            </div>
                        </div>
                        <table class="admin-tb" id="tb1">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">�˺� </th>
                                <th width="12%">�������</th>
                                <th width="18%">��������</th>
                                <th width="10%">ҳ��</th>
                                <th width="10%">IP</th>
                                <th width="13%">����ʱ��</th>
                            </tr>
                            <?php foreach ($datalist as $row): ?>
                                <tr>  <!-- <tr class="checked">Ĭ��ѡ�� -->
                                    <td ><?php echo $row->id ?></td>
                                    <td ><?php echo $row->user->username ?></td>
                                    <td ><?php echo $row->catalog ?></td>
                                    <td><span ><?php echo $row->intro ?></span></td>
                                    <td ><?php echo $row->url ?></td>
                                    <td ><?php echo $row->ip ?></td>
                                    <td ><?php echo date('Y-m-d H:i', $row->create_time) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="foot-ctrl">
                            </tr>
                        </table>

                        <div class="th"><!--/ pages-->
                            <div class="cuspages right">
                            <?php $this->widget('CLinkPager', array('pages' => $pagebar,'header'=>'�ܼ� '.$pagecount.' ��  ')); ?>
                            </div>
                        </div>
                    </div>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
</div><!--/ wrap-->              

<?php $this->renderPartial('/_common/footer'); ?>
