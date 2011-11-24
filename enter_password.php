<?php
// 기본 클래스를 부르고 DB 연결 @sirini
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 작성자 아이피와 현재 방문객의 아이피가 일치하면 비밀번호 확인과정 패스함 (오픈아이디일 경우에만) @sirini
if($_GET['readyWork'] == 'c_delete' && $_SESSION['openID']) {
	$savedPW = $GR->getArray("select ip, homepage from {$dbFIX}comment_".$_GET['id']." where no = '".$_GET['commentNo']."' and member_key = 0");
	if(($_SERVER['REMOTE_ADDR'] == $savedPW['ip']) && $savedPW['homepage']) {
		$GR->query("delete from {$dbFIX}comment_".$_GET['id']." where no = '".$_GET['commentNo']."'");
		$GR->query("update {$dbFIX}bbs_".$_GET['id']." set comment_count = comment_count - 1 where no = '".$_GET['articleNo']."'");
		$GR->error('코멘트를 삭제하였습니다.', 0, 'board.php?id='.$id.'&articleNo='.$articleNo);
	}
}

// 비밀번호를 입력했을 경우 체크 후 게시물 보기 (혹은 삭제) @sirini
if($_POST['enterPassword']) {
	@extract($_POST);

	$id = $_POST['id'];
	$password = $_POST['password'];
	
	if($readyWork == 'view' || $readyWork == 'delete' || $readyWork == 'write') {
		$table = $dbFIX.'bbs_'.$id;
		$valueNo = $articleNo; 
	}
	elseif($readyWork == 'c_delete') {
		$table = $dbFIX.'comment_'.$id;
		$valueNo = $commentNo;
	}
	else $table = $dbFIX.'bbs_'.$id;
	
	$fetchPassword = $GR->getArray("select password from {$table} where no = '$valueNo'");
	$tmpPassword = $GR->getArray("select password('$password') as passwd");

	if($tmpPassword['passwd'] == $fetchPassword['password']) {
		$pass = sha1($tmpPassword[0]);
		if($readyWork == 'write') $goFile = 'write.php';
		elseif($readyWork == 'delete' or $readyWork == 'c_delete') $goFile = 'delete.php';
		else $goFile = 'board.php';
		$GR->move($goFile.'?id='.$id.'&page='.$page.'&articleNo='.$articleNo.'&alreadyEnterPassword='.
			$pass.'&mode=modify&targetTable='.$targetTable.'&commentNo='.$commentNo.'&modifyTarget='.$modifyTarget);
	}
	else $GR->error('비밀번호가 맞지 않습니다.', 0, 'enter_password.php?id='.$id.'&articleNo='.$articleNo.'&readyWork='.$readyWork.'&targetTable='.$targetTable.'&page='.$page);

// 비밀번호 입력 전 @sirini
} else {
	$id = $_GET['id'];
	$page = $_GET['page'];
	$articleNo = $_GET['articleNo'];
	$commentNo = $_GET['commentNo'];
	$readyWork = $_GET['readyWork'];
	$password = $_POST['password'];
	$targetTable = $_GET['targetTable'];
	$modifyTarget = $_GET['modifyTarget'];
}
$setup = $GR->getArray("select head_file, head_form, foot_form, foot_file, theme from {$dbFIX}board_list where id = '$id'");

// 상단 설정 @sirini
if($id && ($setup['head_file'] || $setup['head_form'])) {
	$move = 'board.php?id='.$id;
	$theme = 'theme/'.$setup['theme'];
	if($setup['head_file']) {
		ob_start();
		include $setup['head_file'];
		$content = ob_get_contents();
		ob_clean();
		echo str_replace('</head>', '<link rel="stylesheet" href="out_style.css" type="text/css" title="style" /></head>', $content);
	}
	if($setup['head_form']) {
		$setup['head_form'] = str_replace('</head>', '<link rel="stylesheet" href="out_style.css" type="text/css" title="style" /></head>', $setup['head_form']);
		echo str_replace('[theme]', $theme, $setup['head_form']);
	}
	$hasHeadFoot = true;

// 상/하단 페이지가 없을 떄 @sirini
} else {
	$move = $fromPage;
	$title = 'GR Board Check Password Page';
	include 'html_head.php';
	echo '<body>';
	$hasHeadFoot = false;
}

if($_GET['id']) $id = $_GET['id'];
if($_GET['page']) $page = $_GET['page'];
if($_GET['articleNo']) $articleNo = $_GET['articleNo'];
if($_GET['readyWork']) $readyWork = $_GET['readyWork'];
if($_GET['targetTable']) $targetTable = $_GET['targetTable'];

// 비밀번호 입력 디자인 가져오기 @sirini
if(file_exists('theme/'.$setup['theme'].'/theme_enter_password.php')) include 'theme/'.$setup['theme'].'/theme_enter_password.php';
else include 'enter_password_default.php';

// 하단 설정 @sirini
if($hasHeadFoot) {
	if($setup['foot_file']) include $setup['foot_file'];
	echo $setup['foot_form'];
} else { ?></body></html><?php } ?>