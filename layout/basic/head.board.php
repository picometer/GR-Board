<?php
$grboard = '.';
include $grboard . '/include.php';

// 지정된 opt 값에 맞는 var 를 가져오기
function getVar($opt) {
	global $dbFIX;
	$result = @mysql_fetch_array(mysql_query('select var from '.$dbFIX.'layout_config where opt = \''.$opt.'\''));
	return ($result[0]) ? $result[0] : false;
}

// 페이지에서 사용할 변수 부르기
$getConfigList = array('theme', 'title', 'logo', 'useOutlogin', 'outlogin', 'usePoll', 'poll');
$countList = count($getConfigList);
for($i=0; $i<$countList; $i++) $config[$getConfigList[$i]] = getVar($getConfigList[$i]);
$path = 'layout/'.$config['theme'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="Layout Manager in GR Board" />
<link rel="stylesheet" href="<?php echo $path; ?>/style.css" type="text/css" title="style" />
<title><?php echo $config['title']; ?></title>
<style type="text/css">/*<![CDATA[*/
<?php if($config['useOutlogin']) { ?>@import url(outlogin/<?php echo $config['outlogin']; ?>/style.css);<?php } ?>
<?php if($config['usePoll']) { ?>@import url(latest/<?php echo $config['poll']; ?>/style.css);<?php } ?>
<?php if($config['useLatest']) { ?>@import url(latest/<?php echo $config['latest']; ?>/style.css);<?php } ?>
@import url(<?php echo $theme; ?>/style.css);
/*]]>*/</style>
</head>
<body>

<div id="topLogo">
	<a href="index/"><img src="<?php echo $config['logo']; ?>" alt="사이트 로고" /></a>
</div>

<div id="topMenu">
	<?php
	// 상단 메뉴 가져와서 뿌려주기
	$getTopMenu = @mysql_query('select var from '.$dbFIX.'layout_config where opt = \'topmenu\'');
	while($topMenus = @mysql_fetch_array($getTopMenu)) { 
		$tmpArr = @explode('|', str_replace('../', '', $topMenus['var']));
		$menuName = $tmpArr[0];
		$menuLink = $tmpArr[1];
	?>
		<div class="box"><a href="<?php echo $menuLink; ?>"><?php echo $menuName; ?></a></div>
	<?php } // 여기까지 상단 메뉴 출력 ?>
	<div class="clear"></div>
</div>

<div id="sideMenu">
	<?php if($config['useOutlogin']) outlogin($config['outlogin']); // 외부로그인 출력 ?>
	<div class="menuTitle">주요메뉴</div>
	<?php
	// 사이드 메뉴 가져와서 뿌려주기
	$getSideMenu = @mysql_query('select var from '.$dbFIX.'layout_config where opt = \'sidemenu\'');
	while($sideMenus = @mysql_fetch_array($getSideMenu)) { 
		$tmpArr = @explode('|', str_replace('../', '', $sideMenus['var']));
		$sidemenuName = $tmpArr[0];
		$sidemenuLink = $tmpArr[1];
	?>
		<div class="list"><img src="<?php echo $path; ?>/images/sidemenu.arrow.gif" alt="" /> <a href="<?php echo $sidemenuLink; ?>"><?php echo $sidemenuName; ?></a></div>
	<?php } // 여기까지 사이드 메뉴 출력
	
	if($config['usePoll']) poll($config['poll']); // 최근 설문조사 출력 ?>
</div>

<div id="mainFrame">