<?php
// 기본 클래스를 불러온다.
$header = 'Content-Type: text/xml; charset=utf-8';
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// id 와 no 값 처리
if(isset($_GET['no'])) $no = $_GET['no']; else $no = $_POST['no'];
if(isset($_GET['id'])) $id = $_GET['id']; else $id = $_POST['id'];
if(isset($_GET['grkey'])) $grkey = $_GET['grkey']; else $grkey = $_POST['grkey'];
$no = (int)$no;

// 모든 변수의 유무를 검사
if(!$id && !$no && !$_POST['url'] && !$_POST['title'] && !$_POST['blog_name'] && !$_POST['excerpt'])
{
	die(); //xml헤더이므로 에러 출력이 곤란함. 그냥 종료.
}

if($no && !(int)$no) exit;
//$id = m.ysql_real_escape_string($id);

// XML헤더 전송
echo '<?xml version="1.0" encoding="utf-8"?><response>';

// 스팸차단 (사용자 키 값에 의한 매칭 확인)
$fullkey = substr(md5('grboard'.date('YmdH', time()).$no.$id), -6);
if($grkey != $fullkey) {
	die('<error>1</error><message>키 값이 맞지 않습니다. 1시간 이전에 생성된 트랙백 주소 입니다.</message></response>');
}

// 이 게시판이 트랙백을 받는지 확인
$getConfig = $GR->query("select is_trackback from {$dbFIX}board_list where id = '$id'");
$isTrackback = $GR->fetch($getConfig);
if(!$isTrackback['is_trackback']) die('<error>1</error><message>해당 게시물에 트랙백을 남길 수 없습니다.</message></response>');

// 트랙백을 넣을 게시물이 존재하는지 검사하고 삽입
$check = $GR->getArray("select no from {$dbFIX}bbs_{$id} where no = '$no'");
if(!$check['no']) die('<error>1</error><message>'.
	'해당 게시물이 없거나 삭제되었습니다.</message></response>');

// 트랙백 내용이 비어있는 지 확인
if(!$_POST['blog_name'] || !$_POST['title'] || !$_POST['excerpt']) die('<error>1</error><message>트랙백 내용이 비어있습니다.</message></response>');

// 받은 트랙백이 UTF-8 인코딩이 아니라면 EUC-KR 로 간주하여 UTF-8 로 인코딩
if(function_exists('iconv'))
{
	if(iconv('utf-8', 'utf-8', $_POST['blog_name']) != $_POST['blog_name']) $_POST['blog_name'] = iconv('euc-kr', 'utf-8', $_POST['blog_name']);
	if(iconv('utf-8', 'utf-8', $_POST['title']) != $_POST['title']) $_POST['title'] = iconv('euc-kr', 'utf-8', $_POST['title']);
	if(iconv('utf-8', 'utf-8', $_POST['excerpt']) != $_POST['excerpt']) $_POST['excerpt'] = iconv('euc-kr', 'utf-8', $_POST['excerpt']);
}

// 트랙백이 온 내용 DB 삽입
$thisTime = time();
$password = md5($thisTime);
$ip = $_SERVER['REMOTE_ADDR'];
$name = $GR->escape(htmlspecialchars(trim(stripslashes($_POST['blog_name']))));
$subject = $GR->escape(htmlspecialchars(trim(stripslashes($_POST['title']))));
$originContent = $GR->escape(htmlspecialchars(trim(stripslashes($_POST['excerpt']))));
//$url = m.ysql_real_escape_string($_POST['url']);
$url = $_POST['url'];
$content = '[※ 트랙백이 도착했습니다]'."\n\n".$originContent;
$insertSql = "insert into {$dbFIX}comment_{$id} set no = '', board_no = '$no', family_no = '0',".
	"thread = '0', member_key = '0', is_grcode = '0', name = '$name', password = '$password',".
	"email = '', homepage = '".$url."', ip = '$ip', signdate = '$thisTime', good = '0', bad = '0',".
	"subject = '$subject', content = '$content'";
$GR->query($insertSql);
$insertNo = $GR->getInsertId();

// 패밀리 넘버, 코멘트 수 업데이트
$GR->query("update {$dbFIX}comment_{$id} set family_no = '$insertNo' where no = '$insertNo'");
$GR->query("update {$dbFIX}bbs_{$id} set comment_count = comment_count+1 where no = '$no'");

// 트랙백으로 온 것을 모아서 저장
$trackbackSql = "insert into {$dbFIX}trackback_save set no = '', board_id = '$id', article_no = '$no',".
	"name = '$name', url = '".$url."', subject = '$subject', content = '$originContent', ".
	"signdate = '$thisTime'";
$GR->query($trackbackSql);
	
//최종 리턴
echo '<error>0</error></response>';
?>
