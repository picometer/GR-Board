<?php
// 기본, 블로그 클래스 부르기
include 'class/common.php';
include 'class/blog.php';
$GR = new COMMON;
$BLOG = new BLOG;

// DB 연결
$GR->dbConn();

// 변수처리
$id = $_GET['id'];
$articleNo = $_GET['articleNo'];
if(!$id or !$articleNo) exit();

// 이미 싱크했는지 확인
if(eregi($id.'_'.$articleNo, $_SESSION['is_sync'])) { ?>
<!doctype html>
<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css" title="style" />
<meta charset="utf-8" />
<title>에러</title>
</head>
<body>

<script type="text/javascript">//<![CDATA[
alert('싱크넷(sinkNET™)에 출판하지 못했습니다.\n\n이미 등록하신 게시물입니다.');
self.close();
//]]></script>

<p>싱크넷(sinkNET™)에 출판하지 못했습니다.<br />이미 등록하신 게시물입니다.<br />(창을 닫아주세요)</p>

</body>
</html>
<?php exit(); }

// 게시물 가져오기
$getArticle = @mysql_query('select name, subject from '.$dbFIX.'bbs_'.$id.' where no = '.$articleNo);
$sync = @mysql_fetch_array($getArticle);

// 현재 grboard 의 경로 구하기
$path = str_replace('/sync.php', '', $_SERVER["SCRIPT_NAME"]);
$url = 'http://'.$_SERVER['HTTP_HOST'].$path.'/trackback.php?id='.$id.'&no='.$articleNo;

// 값 처리
$name = htmlspecialchars($sync['name']);
$subject = htmlspecialchars($sync['subject']);
$sinkNET = 'http://sirini.net/sink/sink.php?id='.$id.'&no='.$articleNo;

// 보내고 응답받기
$resultSendTrackback = $BLOG->sendTrackback($sinkNET, $url, $name, $subject, 'GR Board');

// 실패
if($resultSendTrackback) { ?>
<!doctype html>
<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css" title="style" />
<meta charset="utf-8" />
<title>에러</title>
</head>
<body>

<script type="text/javascript">//<![CDATA[
alert('싱크넷(sinkNET™)에 출판하지 못했습니다.\n\n<?php echo $resultSendTrackback; ?>');
self.close();
//]]></script>

<p>싱크넷(sinkNET™)에 출판하지 못했습니다.<br /><?php echo $resultSendTrackback; ?><br />(창을 닫아주세요)</p>

</body>
</html>
<?php 
	exit();
} else { 
	$_SESSION['is_sync'] = $id.'_'.$articleNo; 
}
?>
<!doctype html>
<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css" title="style" />
<meta charset="utf-8" />
<title>완료</title>
</head>
<body>

<script type="text/javascript">//<![CDATA[
alert('이 게시물을 무사히 싱크넷(sinkNET™)에 출판했습니다.');
self.close();
//]]></script>

<p>이 게시물을 무사히 싱크넷(sinkNET™)에 출판했습니다.<br />(창을 닫아주세요)</p>

</body>
</html>