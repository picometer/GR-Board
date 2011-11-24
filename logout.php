<?php
// 기본 클래스를 부른다. @sirini
include 'class/common.php';
$GR = new COMMON;

// 로그인 상태인지 확인 후 멤버 로긴시간을 0으로 초기화한다. @sirini
if(!$_SESSION['no']) $GR->error('로그인 상태가 아닙니다.');
$GR->dbConn();
$GR->query('update '.$dbFIX.'member_list set lastlogin = 0 where no = '.$_SESSION['no'].' limit 1');

// 세션을 삭제처리한다. @sirini
$_SESSION = array();
@session_destroy();
@setcookie('memberKey', '', time()+31536000, '/');

// 문서설정 @sirini
$title = 'GR Board Logout Page';
include 'html_head.php';

// 이동 @sirini
if(strstr($_SERVER['HTTP_REFERER'],'/admin')) $goUrl ='./';
elseif($_SERVER['HTTP_REFERER']) $goUrl = $_SERVER['HTTP_REFERER'];
elseif($_GET['id'] && !$_GET['page']) $goUrl = 'board.php?id='.$_GET['id'];
elseif($_GET['page'] && !$_GET['id']) $goUrl = $_GET['page'];
else $goUrl = 'login.php';
$GR->move($goUrl);
?>