<?php $this->renderPartial('/_common/header'); ?>
<body id="main_page">

<script type="text/javascript">
	var nav = document.getElementById("nav");
	var pnav = window.parent.document.getElementById("nav")
	pnav.innerHTML = nav.innerHTML;
</script>
<div class="wrap">
    <div class="container">
        <div id="main">
            <div class="con">
		  <div class="table">
                    <h2 class="th">114����ַ������վϵͳ</h2>       
                    <table><tr><td>
                        <p>
                            ��ӭʹ������ľ��114����ַ������վϵͳ����ǰ�汾�ţ�V<?php echo SYS_VERSION?>��������ʱ�䣺<?php echo SYS_UPTIME?>��
                            <a href='<?php echo QZ_URL?>' target='_blank' style="float:right;">�μ�114����ַ������վϵͳ��Դ����Ȧ��&gt;&gt;</a>
                        </p>
                        <div class="table" id="version_notice" style="display:none;background-color:#fff">            
                            <p class="tips"></p>
                        </div>
                    </td></tr></table>
                </div>

                <?php if(!empty($data['tips'])):?>
                <div class="table">
                    <h2 class="th">��ȫ��ʾ</h2>       
                    <div class="tips">
                        <?php if (!empty($data['tips']['backend'])):?>
                        <p>�Ӱ�ȫ�Կ��ǣ��������޸�Ĭ�Ϲ����̨Ŀ¼ admin Ϊ�Զ���Ŀ¼��;</p>
                        <?php endif;?>
                        <?php if (!empty($data['tips']['install'])):?>
                        <p>��װĿ¼ install �Դ��ڣ�������ɾ����Ŀ¼,�����޸�Ŀ¼��;</p>
                        <?php endif;?>
						<?php if (!function_exists('curl_init')):?>
                        <p>PHP��curl_init��չδ����,ͬ��������Ч;</p>
                        <?php endif;?>
                        <p></p>
                    </div>
                </div>
              <?php endif;?>
                
                <div class="table">
                    <h2 class="th">������������Ϣ <span class="head"><?php echo $_SERVER['SERVER_NAME']?><?php echo $data['serverip']?> &nbsp;<?php echo $data['systime']?></span></h2>                
                    <table>
                        <tr>
                        <td colspan="2"> System : <?php echo $data['sysinfo']?></td>
                        <td colspan="2">Web server : <span class="b"><?php echo $_SERVER['SERVER_SOFTWARE']?></span></td>
                        <td colspan="2">PHP Version : <?php echo $data['phpversion']?></td>
                        </tr>
                        <tr>
                        <td colspan="2">Mysql  Version : <?php echo $data['dbversion']?></td>
                        <td colspan="2"> display_errors : <?php echo $data['dispalyerror']?></td>
                        <td colspan="2">Server API : <?php echo $data['serverapi']?></td>
                        </tr>
                        <tr>
                        <td colspan="2">PHP Safe: <?php echo $data['phpsafe']?> </td>
                        <td colspan="2">Session Support : <?php echo $data['sessionsp']?></td>
                        <td colspan="2">Cookie Support : <?php echo $data['cookiesp']?></td>
                        </tr>
                        <tr>
                        <td colspan="2">Zend Optimizer Support : <?php echo $data['zendoptsp']?></td>
                        <td colspan="2">eAccelerator Support : <?php echo $data['eaccsp']?></td>
                        <td colspan="2">Xcache Support : <?php echo $data['xcachesp']?></td>
                        </tr>
                        <tr>
                        <td colspan="2">register_globals : <?php echo $data['registerglobal']?></td>
                        <td colspan="2">magic_quotes_gpc : <?php echo $data['mqqsp']?></td>
                        <td colspan="2">magic_quotes_runtime : <?php echo $data['mprsp']?></td>
                        </tr>
                        <tr>
                        <td colspan="2">upload_max_filesize : <?php echo $data['maxupsize']?></td>
                        <td colspan="2">post_max_size : <?php echo $data['maxpostsize']?></td>
                        <td colspan="2">max_execution_time : <?php echo $data['maxexectime']?></td>
                        </tr>
                        <tr>
                        <td width="12%">allow_url_fopen : <?php echo $data['allowurlopen']?></td>
                        <td width="13%">Curl Support : <?php echo $data['curlsp']?></td>
                        <td width="12%">Iconv Support : <?php echo $data['iconvsp']?></td>
                        <td width="13%">Zlib Support : <?php echo $data['zlibsp']?></td>
                        <td width="12%">GD Support : <?php echo $data['gdsp']?></td>
                        <td width="13%">DBA Support : <?php echo $data['dbasp']?></td>
                        </tr>
                    </table>
                </div>                
                <div class="table">
                    <h2 class="th">ͳ����Ϣ</h2>                
                    <table>
                    <tr>
                    <td> ��ǰ������ : <?php echo $data['sitesum']?>��</td>
                    <td>���ݿ��С : <?php echo $data['datasize']?></td>
                    </tr>
                    </table>
                </div>
            </div><!--/ con-->
        </div>    
    </div><!--/ container-->
</div><!--/ wrap-->

<?php $this->renderPartial('/_common/footer'); ?>