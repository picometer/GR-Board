<?php
// 기본 클래스를 부른다 @sirini
include 'class/common.php';
$GR = new COMMON;

// 로그인 상태가 아니면 에러 @sirini
if(!$_SESSION['no']) {
	die('<!doctype html><html><head><meta charset="utf-8" /><title>에러페이지</title>'.
	'<script> alert(\'멤버만이 멤버에게 쪽지를 보낼 수 있습니다. 로그인 해 주세요.\'); self.close(); </script></body></html>');
}

$GR->dbConn();

// 변수처리 @sirini
if($_SESSION['no']) $sessionNo = $_SESSION['no']; else $sessionNo = 0;

// 쪽지가 보내졌다면 처리 @sirini
if($_POST['sendOk']) {
	// 입력검사
	if(strlen(trim($_POST['subject']))==0)$GR->error('제목을 입력해 주세요', 0, 'HISTORY_BACK');
	if(strlen(trim($_POST['content']))==0)$GR->error('내용을 입력해 주세요', 0, 'HISTORY_BACK');
	$targetKey = (int)$_POST['targetKey'];
	$isMember = $GR->getArray('select id from '.$dbFIX.'member_list where no =\''.$targetKey.'\'');
	if(!$isMember['id'])$GR->error('받는 사람의 회원 정보가 없습니다.', 0, 'HISTORY_BACK');
	$subject = htmlspecialchars(trim($_POST['subject']));
	$content = htmlspecialchars(trim($_POST['content']));
	$thisTime = $GR->grTime();
	$GR->query("insert into {$dbFIX}memo_save set no = '', member_key = '$targetKey', sender_key = '$sessionNo', ".
		"subject = '$subject', content = '$content', signdate = '$thisTime', is_view = '0'");
	$GR->error($_POST['targetName'].' 님에게 쪽지를 보냈습니다.', 0, 'CLOSE');
}

// 쪽지 받을 대상 @sirini
$target = (int)$_GET['target'];
$targetInfo = $GR->getArray("select nickname, realname from {$dbFIX}member_list where no = '$target'");

// 회원의 정보를 가져온다. @sirini
$member = $GR->getArray('select * from '.$dbFIX.'member_list where no = '.$sessionNo);

// 문서설정 @sirini
$getMemo = $GR->getArray('select var from '.$dbFIX.'layout_config where opt = \'memo_skin\' limit 1');
if(!$getMemo['var']) $getMemo['var'] = 'default';
$title = 'GR Board Send Memo Page';
include 'html_head.php';
?>
<body>
<?php
// 쪽지함 스킨 부르기 @sirini
include 'admin/theme/memo/'.$getMemo['var'].'/send_memo.php';
?>
</body>
</html>