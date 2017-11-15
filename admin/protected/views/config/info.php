<?php $this->renderPartial('/_common/header'); ?>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con box-green">
                <?php $form = $this->beginWidget('CActiveForm',array('htmlOptions'=>array('enctype'=>'multipart/form-data'),)); ?>
                <div class="box-content">
                    <table class="table-font">
                        <tr>
                            <th class="w120">��վ���⣺</th>
                            <td><input type="text" class="textinput w360" name="config[site_name]" value="<?php if(!empty($config['site_name'])): echo $config['site_name']; endif;?>" /></td>
                        </tr>
                        <tr>
                            <th>��վ��ַ��</th>
                            <td><input type="text" class="textinput w360" name="config[site_domain]" value="<?php if(!empty($config['site_domain'])): echo $config['site_domain']; endif;?>" /></td>
                        </tr>
                        <tr>
                            <th>��վlogo��</th>
                            <td>
                                <input type="file" class="" name="site_logo" /> <?php if(!empty($config['site_logo'])): ?><img href="<?php echo $config['site_logo'];?>" /> <?php endif;?>
                                logoͼƬ�� : <input type="text" class="textinput w80" name="config[site_logo]" value="<?php if(!empty($config['site_logo'])): echo $config['site_logo']; else: echo 'logo.png'; endif;?>" /> ��: png,gif,jpg��ʽ
                            </td>
                        </tr>
                        <tr>
                            <th>ICP������Ϣ��</th>
                            <td><input type="text" class="textinput w360" name="config[site_icp]" value="<?php if(!empty($config['site_icp'])): echo $config['site_icp']; endif;?>" /></td>
                        </tr>
                        <tr>
                            <th>ICP�������ӵ�ַ��</th>
                            <td><input type="text" class="textinput w360" name="config[site_icp_url]" value="<?php if(!empty($config['site_icp_url'])): echo $config['site_icp_url']; endif;?>" /></td>
                        </tr>
                        <tr>
                            <th>SEO-title��</th>
                            <td><input type="text" class="textinput w360" name="config[seo_title]" value="<?php if(!empty($config['seo_title'])): echo $config['seo_title']; endif;?>" /></td>
                        </tr>
                        <tr>
                            <th>SEO-keywords��</th>
                            <td><input type="text" class="textinput w360" name="config[seo_keywords]" value="<?php if(!empty($config['seo_keywords'])): echo $config['seo_keywords']; endif;?>" /></td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">SEO-description��</th>
                            <td><textarea class="w360" name="config[seo_description]"><?php if(!empty($config['seo_description'])): echo $config['seo_description']; endif;?></textarea></td>
                        </tr>
                        <tr>
                            <th>��Ȩ��Ϣ��</th>
                            <td><input type="text" class="textinput w360" name="config[site_copyright]" value="<?php if(!empty($config['site_copyright'])): echo $config['site_copyright']; endif;?>" /></td>
                        </tr>
                        <tr>
                            <th  style="vertical-align:top;">���������룺</th>
                            <td><textarea class="w360" name="config[site_stats]"><?php if(!empty($config['site_stats'])): echo $config['site_stats']; endif;?></textarea></td>
                        </tr>
                        <tr>
                            <th>ͼƬ�����ϴ���С��</th>
                            <td><input type="text" class="textinput w360" name="config[upload_max_size]" value="<?php if(!empty($config['upload_max_size'])): echo $config['upload_max_size']; endif;?>" /> KB</td>
                        </tr>
                        <tr>
                            <th>ͼƬ�����ϴ����ͣ�</th>
                            <td><input type="text" class="textinput w360" name="config[upload_allow_ext]" value="<?php if(!empty($config['upload_allow_ext'])): echo $config['upload_allow_ext']; endif;?>" /> �� | �ָ�</td>
                        </tr>
                        <tr>
                            <th>��ҳ����λ�ã�</th>
                            <td><input type="text" class="textinput w360" name="config[path_inside_page]" value="<?php if(!empty($config['path_inside_page'])): echo $config['path_inside_page']; else: echo '/html'; endif;?>" /> 
							�������Ŀ¼,Ĭ��Ϊ /html <?php if(!empty($config['path_inside_page'])):echo '��ǰΪ '.$config['path_inside_page']; if(!is_dir(substr(SITE_PATH,0,-1).$config['path_inside_page']) || !is_writable(substr(SITE_PATH,0,-1).$config['path_inside_page'])): echo ', ��Ŀ¼����д!���Ϊ��д! '.substr(SITE_PATH,0,-1).$config['path_inside_page'];  endif; endif;?></td>
                        </tr>
                        </tr>
                        <tr>
                            <th>�Ƿ��Cron��</th>
                            <td>
                                <label><input type="radio" name="config[is_cron]" value="0" <?php if(empty($config['is_cron'])): ?> checked="checked" <?php endif;?>/>�ر�</label>&nbsp;
                                <label><input type="radio" name="config[is_cron]" value="1" <?php if(!empty($config['is_cron'])): ?> checked="checked" <?php endif;?>/>����</label>&nbsp;&nbsp;<br />
                            </td>
                        </tr>
                        <tr>
                            <th>��־���ܣ�</th>
                            <td>
                                <label><input type="radio" name="config[admin_logger]" value="0" <?php if(empty($config['admin_logger'])): ?> checked="checked" <?php endif;?>/>�ر�</label>&nbsp;
                                <label><input type="radio" name="config[admin_logger]" value="1" <?php if(!empty($config['admin_logger'])): ?> checked="checked" <?php endif;?>/>����</label>&nbsp;&nbsp;<br />
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-footer-inner">
                    	<input type="submit" value="�������" />
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div><!--/ con-->
            
        </div>    
    </div><!--/ container-->

</div><!--/ wrap-->
<?php $this->renderPartial('/_common/footer'); ?>

