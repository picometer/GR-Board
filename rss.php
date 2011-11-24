<?php
$headerGiven = 'N';
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 변수 처리 @sirini
if(isset($_GET['id'])) $id = $_GET['id'];
if(isset($_GET['isReply'])) $isReply = true;
if(isset($_GET['select'])) $select = $_GET['select'];

// 블로그 클래스를 불러온다. @sirini
include "class/blog.php";
$RSS = new BLOG;

if(!$id) {
	$RSS->allRss($select);
	exit();
}

// 권한 검사 @sirini
$viewOk = $GR->getArray("select view_level, is_rss from {$dbFIX}board_list where id = '$id'");
if( !$viewOk['is_rss'] ) {
	header('Content-Type: text/html; charset=utf-8');
	die('볼 수 있는 권한이 없습니다.'); //!!!확인필요 XHTML
}

// RSS 생성하기 @sirini
if($isReply) $RSS->replyRss($id); 
else $RSS->makeRss($id);
?>