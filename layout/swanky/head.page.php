<?php/*

Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : Swanky
Description: A three-column, fixed-width design suitable for news sites and blogs.
Version    : 1.0
Released   : 20080227

--

Modified for GR Board ( Remake by Hee Geun Park, Korea )
http://sirini.net
Released for GR Board Layout manager (also FREE and CCL 2.5 License)

*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="Layout Manager in GR Board" />
<link rel="stylesheet" href="<?php echo $path; ?>/style.css" type="text/css" title="style" />
<title><?php echo $config['title']; ?></title>
<style type="text/css">/*<![CDATA[*/
<?php if($config['useOutlogin']) { ?>@import url(../outlogin/<?php echo $config['outlogin']; ?>/style.css);<?php } ?>
<?php if($config['usePoll']) { ?>@import url(../latest/<?php echo $config['poll']; ?>/style.css);<?php } ?>
<?php if($config['useLatest']) { ?>@import url(../latest/<?php echo $config['latest']; ?>/style.css);<?php } ?>
/*]]>*/</style>
</head>
<body>
<!-- start header -->
<div id="header">
	<div id="menu">
		<ul>
		<?php
		// 상단 메뉴 가져와서 뿌려주기
		$grboardName = str_replace('/page.php', '', $_SERVER['SCRIPT_NAME']);
		$getTopMenu = @mysql_query('select var from '.$dbFIX.'layout_config where opt = \'topmenu\'');
		while($topMenus = @mysql_fetch_array($getTopMenu)) { 
			$tmpArr = @explode('|', $topMenus['var']);
			$menuName = $tmpArr[0];
			$menuLink = str_replace('/board.php', $grboardName.'/board.php', $tmpArr[1]);
			$menuLink = str_replace('/page.php', $grboardName.'/page.php', $menuLink);
		?>
			<li><a href="<?php echo $menuLink; ?>"><?php echo $menuName; ?></a></li>
		<?php } // 여기까지 상단 메뉴 출력 ?>
		</ul>
	</div>
</div>
<div id="logo">
	<h1><a href="./"><?php echo $config['title']; ?></a></h1>
	<h2> Welcome to my sweet home</h2>
</div>
<!-- end header -->
<hr />

<!-- Start GR Board Page -->
<div id="grboardPage">