<?php
// 기본 클래스를 불러온다. @sirini
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 제목, 내용 처리 @sirini
$original = array('@amp;', '@plus;', '@percent;', '@sharp;', '@question;', '@equal;');
$change = array('&', '+', '%', '#', '?', '=');
$subject = str_replace($original, $change, $_POST['subject']);
$content = str_replace($original, $change, $_POST['content']);
$time = time();

// 멤버일 시 임시 저장 처리 @sirini
if($_SESSION['no']) {
	$getExist = $GR->getArray('select no from '.$dbFIX.'auto_save where member_key = '.$_SESSION['no']);
	if(!$getExist['no']) $sql = "insert into {$dbFIX}auto_save set no = '', member_key = '".$_SESSION['no']."', subject = '$subject', content = '$content', signdate = '$time'";
	else $sql = "update {$dbFIX}auto_save set subject = '$subject', content = '$content', signdate = '$time' where member_key = ".$_SESSION['no'];
	$GR->query($sql);

// 일반 사용자일 경우 쿠키로 처리 @sirini
} else {
	@setcookie('grSubject', $subject, $time+3600);
	@setcookie('grContent', $content, $time+3600);
	@setcookie('grDate', $time, $time+3600);
}
?>