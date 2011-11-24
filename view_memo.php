<?php
// 기본 클래스를 부른다 @sirini
include 'class/common.php';
$GR = new COMMON;

// 로그인 상태가 아니면 에러 @sirini
if(!$_SESSION['no']) $GR->error('멤버만이 자신의 쪽지함을 열어볼 수 있습니다. 로그인 해 주세요.', 0, 'CLOSE');

$GR->dbConn();

// 변수 처리 @KISA
if($_GET['action'] && preg_match("/[^0-9]/i", $_GET['action'])) exit();
if($_GET['viewMemoNo'] && preg_match("/[^0-9]/i", $_GET['viewMemoNo'])) exit();
$viewNo = (int)$_GET['viewMemoNo'];
if($_SESSION['no']) $sessionNo = $_SESSION['no']; else $sessionNo = 0;
if(!$_GET['action']) $action = 1; else $action = $_GET['action'];
$action = (int)$action;

// 쪽지를 삭제했을 경우 처리하고 새로 고침 @sirini
if($_GET['deleteMemoNo']) {
	$deleteNo = (int)$_GET['deleteMemoNo'];
	$getMemo = $GR->getArray('select member_key, sender_key, is_view from '.$dbFIX.'memo_save where no = '.$deleteNo);
	if($getMemo['is_view']=='1') {
		$GR->error('이미 열람한 쪽지는 삭제할 수 없습니다.', 0, 'view_memo.php');
	}
	if($getMemo['member_key']!=$sessionNo) {
		$GR->error('침입 시도 : 타인의 쪽지를 삭제하려 함', 1, 'view_memo.php');
	}
	$GR->query('delete from '.$dbFIX.'memo_save where (member_key = '.$sessionNo.' or sender_key = '.$sessionNo.') and no = '.$deleteNo);
	$GR->error('쪽지를 삭제했습니다.', 0, 'view_memo.php');
}

// 선택한 쪽지들을 삭제처리 @sirini
$ignore = 0;
if($_POST['delTargets'][0]) {

	// XSS 방지 @sirini
	if ($_POST['delTargets'] && !(int)$_POST['delTargets']) exit;
	$delTargets = $_POST['delTargets'];
	$delCnt = @count($delTargets);
	for($dm=0; $dm<$delCnt; $dm++) {
		$getMemo = $GR->getArray('select member_key, sender_key, is_view from '.$dbFIX.'memo_save where no = '.$delTargets[$dm]);
		if($getMemo['is_view']) {
			++$ignore;
			continue;
		}
		$GR->query('delete from '.$dbFIX.'memo_save where (member_key = '.$sessionNo.' or sender_key = '.$sessionNo.') and no = '.$delTargets[$dm]);
	}
	$GR->error('상대방이 확인한 '.$ignore.'개 쪽지를 제외한<br /><br />쪽지들을 모두 삭제하였습니다.', 0, 'view_memo.php');
}

// 페이징처리 @sirini
$page = (int)$_GET['page'];
if(!$page or $page < 0) $page = 1;
$fromRecord = ($page - 1) * 10;

// 문서설정 @sirini
$getMemo = $GR->getArray('select var from '.$dbFIX.'layout_config where opt = \'memo_skin\' limit 1');
if(!$getMemo['var']) $getMemo['var'] = 'default';
$title = 'GR Board View Memo Page';
include 'html_head.php';

// 쪽지함 스킨 부르기 @sirini
include 'admin/theme/memo/'.$getMemo['var'].'/memo.php';
?>

<script>
function deleteMemo(no) {
	if(confirm('선택한 쪽지를 정말로 삭제하시겠습니까?\n\n'+
		'삭제된 쪽지는 다시 복구할 수 없습니다.')) {
		location.href='view_memo.php?deleteMemoNo='+no;
	}
}

function adjustMemo() {
	if(!confirm('선택하신 쪽지들을 정말로 삭제하시겠습니까?\n\n'+
		'삭제된 쪽지는 다시 복구할 수 없습니다.')) {
		return;
	}
	var i, isChecked=0, f = document.forms['list'];
	for(i=0; i<f.length; i++) {
		if(f[i].type=='checkbox') if(f[i].checked) isChecked++;
	}
	if(!isChecked) alert('삭제할 쪽지를 하나 이상 선택해 주세요.');
	else f.submit();
}

function selectAll() {
	var j, f = document.forms['list'];
	for(j=0; j<f.length; j++) if(f[j].type=='checkbox') f[j].checked = !f[j].checked;
}
</script>

</body>
</html>
