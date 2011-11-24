<?php
$preRoute = '../';
$headerGiven = 'Content-Type: text/xml; charset=utf-8';
include $preRoute.'class/common.php';
$GR = new COMMON;
$GR->dbConn();

if(!$_POST['targetNo']) exit();
$targetNo = $_POST['targetNo'];

// 투표 반영
if($targetNo)
{
	if(ereg('vote'.$targetNo, $_SESSION['alreadyPoll'])) die('<?xml version="1.0" encoding="utf-8"?><msg>이미 투표 하셨습니다.</msg>');
	@mysql_query("update {$dbFIX}poll_option set vote = vote + 1 where no = '".$targetNo."'");
	$_SESSION['alreadyPoll'] .= 'vote'.$targetNo.',';
	echo '<?xml version="1.0" encoding="utf-8"?><msg>투표를 완료하였습니다.</msg>';
}
?>