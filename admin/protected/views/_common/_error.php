<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>����<?php echo $code; ?></title>

</head>
<body>
<div id="error">
  <h1><?php echo $code; ?></h1>
  <div class="message"><?php echo $message ?></div>
  <div class="redirect"><a href="<?php echo $this->createUrl('default/welcome')?>">�ص���ҳ</a></div>
</div>
</body>
</html>