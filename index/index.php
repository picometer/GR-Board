<?php
$grboard = '..';
include $grboard . '/include.php';

// 지정된 opt 값에 맞는 var 를 가져오기
function getVar($opt) {
	global $dbFIX;
	$result = @mysql_fetch_array(mysql_query('select var from '.$dbFIX.'layout_config where opt = \''.$opt.'\''));
	return ($result[0]) ? $result[0] : false;
}

// 사용할 테마의 head~foot 부르기
$getConfigList = array('theme', 'title', 'logo', 'useOutlogin', 'outlogin', 'usePoll', 'poll', 'mainImage', 'useLatest', 'showBoard', 'latest', 'latestNum');
$countList = count($getConfigList);
for($i=0; $i<$countList; $i++) $config[$getConfigList[$i]] = getVar($getConfigList[$i]);
$path = '../layout/'.$config['theme'];
include '../layout/'.$config['theme'].'/head.php';
include '../layout/'.$config['theme'].'/main.php';
include '../layout/'.$config['theme'].'/foot.php';
?>