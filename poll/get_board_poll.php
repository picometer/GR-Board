<?php
$headerGiven = 'Content-Type: text/xml; charset=utf-8';
$preRoute = '../';
include $preRoute.'class/common.php';
$GR = new COMMON;
$GR->dbConn();

if(!$_POST['getNo']) exit();
$getNo = $_POST['getNo'];
$getPollSubject = @mysql_fetch_array(mysql_query('select subject from '.$dbFIX.'poll_subject where no = '.$getNo));
$getPollOptions = @mysql_query('select no, title from '.$dbFIX.'poll_option where poll_no = '.$getNo);
$xml = '<?xml version="1.0" encoding="utf-8"?><lists><subject>'.$getPollSubject['subject'].'</subject>';
while($options = @mysql_fetch_array($getPollOptions)) {
	$xml .= '<option no="'.$options['no'].'">'.$options['title'].'</option>';
}
$xml .= '</lists>';
echo $xml;
?>