<?php
include 'class/common.php';
$GR = new COMMON;

// $id 값이 넘어왔을 땐 바로 게시판쪽으로 이동 @sirini
if($_GET['id']) @header('location: board.php?id='.$_GET['id']);

// 미설치시 설치, layout 사용시 이동 @sirini
if(!file_exists('db_info.php')) $GR->error('GR Board 가 설치되어 있지 않습니다. 설치페이지로 이동합니다.', 0, 'install/');
else $GR->move('http://'.$_SERVER['HTTP_HOST']);
?>