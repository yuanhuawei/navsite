<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心-114啦网址导航建站系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<meta content="www.114la.com" name="Copyright" />
<style type="text/css">
html{ overflow:hidden;}
table,td,th, body,dt,dd,dl{ margin:0; padding:0; border:none;}
#nav { background: repeat-x url(<?php echo STATIC_BACKEND_URL?>images/repeat.gif) 0 -209px ; font-size:12px; position:static; top:0; left:0;height:32px; line-height:26px; padding: 0 10px; }
#nav a { color:#666; text-decoration:none; }
#nav a:hover { color:#f60; text-decoration:underline;}
#nav dt, #nav dd { float:left;}
#nav dd { color:#999;}
#nav dt,#nav dd.link {padding-right:16px; background:url(<?php echo STATIC_BACKEND_URL?>images/images.gif) no-repeat right -204px;}
</style>

</head>
<body scroll="no" onLoad="init()"><!-- onLoad="init();"-->
<table cellpadding="0" cellspacing="0" width="100%" height="100%">
    <tr>
        <td colspan="2" height="59"><iframe src="<?php echo $this->createUrl('default/top')?>" name="header" target="menu" width="100%" height="59" scrolling="no" frameborder="0"></iframe></td>
    </tr>
    <tr>
        <td valign="top" rowspan="2" width="136"><iframe src="<?php echo $this->createUrl('default/menu')?>" name="menu" target="main" width="136" height="100%" scrolling="no" frameborder="0"></iframe></td>
        <td valign="top" width="100%">
        
        	<table  cellpadding="0" cellspacing="0" width="100%" height="100%">
                <tr>
                    <td valign="top" width="100%"><iframe src="<?php echo $this->createUrl('default/welcome')?>" id="main" name="main" width="100%" height="100%" frameborder="0" scrolling="yes" style="overflow:visible;"></iframe></td><!--  ?c=login&a=welcome  -->
                </tr>
            </table>
        
        </td>
    </tr>
</table>

</body>
</html>