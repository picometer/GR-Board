<?php
$headerGiven = 'Content-Type: text/xml; charset=utf-8';
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 결과값 주기 @sirini
if($_POST['searchText']) {
	
	$boardID = $_POST['boardID'];
	$searchText = $_POST['searchText'];
	$searchOption = $_POST['searchOption'];
	$searchText = str_replace(array('_', '%', '\\'), array('\_', '\%', '\\\\\\\\'), $searchText);
	$xml  = '<?xml version="1.0" encoding="utf-8"?><lists>';
	$test = $GR->getArray('select no from '.$dbFIX.'bbs_'.$boardID.' where '.$searchOption." like '%".$searchText."%' limit 1");
	
	if(!$test['no']) {
		$xml .= '<item no="0"><title>검색 결과가 없습니다.</title></item></lists>';
		die($xml);
	}
	
	$result = $GR->query('select no, subject from '.$dbFIX.'bbs_'.$boardID.' where '.$searchOption." like '%".$searchText."%' limit 10");
	while($list = $GR->fetch($result)) {
		$xml .= '<item no="'.$list['no'].'"><title>'.htmlspecialchars(stripslashes($list['subject'])).'</title></item>';
	}
	$xml .= '</lists>';
	echo $xml;
}
?>