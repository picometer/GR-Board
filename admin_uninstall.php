<?php
// 기본 클래스를 불러온다.
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 관리자인지 확인한다.
if($_SESSION['no'] != 1) $GR->error('관리자 화면은 관리자만 접근할 수 있습니다.', 1, 'CLOSE');

// 한 번 더 삭제하겠냐는 물음에 YES 일 시 아래 처리
if( $_POST['isSure'] == 'YES' ) {
	
	// 먼저 생성된 게시판 테이블과 코멘트 테이블들을 삭제한다.
	$getDeleteTarget = $GR->query('select id from '.$dbFIX.'board_list') or $GR->error('게시판 삭제목록을 가져오는데 실패했습니다.', 0, 'admin.php');
	
	// 가져온 목록 순서대로 테이블들을 삭제한다.
	while($deleteId = $GR->fetch($getDeleteTarget)) {
		$deleteID = $deleteId['id'];
		$GR->query('drop table '.$dbFIX.'bbs_'.$deleteID);
		$GR->query('drop table '.$dbFIX.'comment_'.$deleteID);
	}
	
	// 기본적으로 생성되는 테이블들도 삭제한다.
	$GR->query('drop table '.$dbFIX.'board_list');
	$GR->query('drop table '.$dbFIX.'member_list');
	$GR->query('drop table '.$dbFIX.'pds_save');
	$GR->query('drop table '.$dbFIX.'error_save');
	$GR->query('drop table '.$dbFIX.'memo_save');
	$GR->query('drop table '.$dbFIX.'group_list');
	$GR->query('drop table '.$dbFIX.'poll_comment');
	$GR->query('drop table '.$dbFIX.'poll_option');
	$GR->query('drop table '.$dbFIX.'poll_subject');
	$GR->query('drop table '.$dbFIX.'time_bomb');
	$GR->query('drop table '.$dbFIX.'total_article');
	$GR->query('drop table '.$dbFIX.'total_comment');
	$GR->query('drop table '.$dbFIX.'member_group');
	$GR->query('drop table '.$dbFIX.'layout_config');
	$GR->query('drop table '.$dbFIX.'report');
	$GR->query('drop table '.$dbFIX.'auto_save');
	$GR->query('drop table '.$dbFIX.'pds_extend');
	$GR->query('drop table '.$dbFIX.'tag_list');
	$GR->query('drop table '.$dbFIX.'article_option');
	$GR->query('drop table '.$dbFIX.'login_log');
	$GR->query('drop table '.$dbFIX.'pds_list');
	$GR->query('drop table '.$dbFIX.'notification');
	
	// DB 접속 저장파일을 삭제한다.
	@chmod('db_info.php', 0707);
	@unlink('db_info.php') or $GR->error('DB 접속정보 파일(db_info.php)을 삭제하는데 실패했습니다.');
	
	// 삭제되었음을 알리고 설치페이지로 이동한다.
	$GR->error('GR Board 가 생성한 DB 자료들을 삭제했습니다.<br /><br />그 동안 사용해 주셔서 감사합니다.<br /><br />'.
		'완전한 삭제를 위해서는 GR Board 디렉토리를<br /><br />FTP로 접근하여 완전히 제거하셔야 합니다.'.
		'(재설치 사용자분을 위해 설치화면으로 이동 합니다.)', 0, 'install.php');
	
}

$title = 'GR Board Uninstall re-confirm Page';
include 'html_head.php';
?>
<body>

<div id="msgBox">

	<div id="inputPass" class="mvLoginBack">
		<div class="mv">GR Board 삭제 최종확인</div>
		<form id="checkUninstall" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div><input type="hidden" name="isSure" value="YES" /></div>
					
		<div class="tableListLine">
			<div class="tableRight">정말로 <strong>GR Board</strong> 를 <strong><span style="color: red">삭제</span></strong> 하시겠습니까?</div>
			<div class="clear"></div>
		</div>

		<div class="submitBox">
			<input type="submit" value="삭제하기" />
			<input type="button" value="취소" onclick="alert('휴 다행이다~ ^^;'); history.back();" />
		</div>

	</form>
	</div>

</div>

</body>
</html>
