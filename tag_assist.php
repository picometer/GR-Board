<?php
// 기본 클래스를 부른다 @sirini
$headerGiven = 'Content-type: text/xml; charset=utf-8';
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 결과값 주기 @sirini
if($_POST['tag']) {
	$xml  = '<?xml version="1.0" encoding="utf-8"?><lists>';
	$sql = 'select tag, count from '.$dbFIX.'tag_list where id = \''.$GR->escape($_POST['id']).'\' and tag'." like '%{$_POST['tag']}%' limit 1";
	$test = $GR->getArray($sql);
	if(!$test[0]) {
		$xml .= '<tags count="0">관련 태그를 찾을 수 없습니다.</tags></lists>';
		die($xml);
	}

	$result = $GR->query($sql);
	while($list = $GR->fetch($result)) {
		$xml .= '<tags count="'.$list['count'].'">'.$list['tag'].'</tags>';
	}
	$xml .= '</lists>';
	echo $xml;
}
?>