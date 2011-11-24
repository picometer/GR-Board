<?php
// 기본 클래스를 부른다 @sirini
include 'class/common.php';
$GR = new COMMON;

// 로그인 상태가 아니면 에러 @sirini
if(!$_SESSION['no']) $GR->error('멤버만이 자신의 스크랩북을 열어볼 수 있습니다.', 0, 'CLOSE');

$GR->dbConn();

// 변수 처리 @sirini
$viewNo = $_GET['viewNo'];
$viewID = $_GET['viewID'];
$viewPostNo = $_GET['viewPostNo'];

$getScrapView = $GR->getArray('select var from '.$dbFIX.'layout_config where opt = \'scrap_view_skin\' limit 1');
if(!$getScrapView['var']) $getScrapView['var'] = 'default';

// 스크랩 추가하기 처리 @sirini
if($_POST['addScrap']) {

	$GR->query("insert into {$dbFIX}scrap_book set no = '', member_key = ".$_SESSION['no'].
		", id = '".$_POST['id']."', article_num = ".$_POST['article_num'].", comment = '".$_POST['comment']."'");
	$GR->error('스크랩을 추가했습니다.', 0, 'view_scrap.php');
}

// 스크랩을 삭제했을 경우 처리하고 새로 고침 @sirini
if($_GET['deleteTarget']) {
	$deleteNo = $_GET['deleteTarget'];
	$GR->query('delete from '.$dbFIX.'scrap_book where no = '.$deleteNo) or $GR->error('스크랩을 삭제하지 못했습니다.');
	$GR->error('선택하신 스크랩을 삭제했습니다.', 0, 'view_scrap.php');
}

// 페이징처리 @sirini
$page = $_GET['page'];
if(!$page || $page < 0) $page = 1;
$fromRecord = ($page - 1) * 10;

// 문서설정 @sirini
$title = 'GR Board View Scrap Book';
include 'html_head.php';

// 스크랩북 열람 스킨 부르기 @sirini
include 'admin/theme/scrap/'.$getScrapView['var'].'/view.php';
?>

<script>
function deleteScrap(no) {
	if(confirm('선택한 스크랩을 정말로 삭제하시겠습니까?\n\n삭제된 스크랩은 다시 복구할 수 없습니다.')) {
		location.href='view_scrap.php?deleteTarget='+no;
	}
}
</script>

</body>
</html>
