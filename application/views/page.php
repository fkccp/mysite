<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh_cn">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?=$title?></title>
	<link rel="stylesheet" href="/static/css/style.css" />
	<script type="text/javascript" src="/static/js/JQ.js"></script>
	<script type="text/javascript" src="/static/js/global.js"></script>
	<?foreach($csses as $css):?><link rel="stylesheet" href="<?=$css?>" /><?endforeach?>
	<?foreach($jses as $js):?><script type="text/javascript" src="<?=$js?>"></script><?endforeach?>
</head>
<body>
	<?=$header?>
	<div class="wrapper">
		<?=$body?>
		<div class="clear"></div>
		<div id="footer">
			© 2013 douban.com, all rights reserved. <a href="/help/about">关于网站</a> <a href="/help">帮助中心</a>
		</div>
	</div>
</body>
</html>