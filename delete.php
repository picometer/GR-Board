<?php
// 기본 클래스를 부른다 @sirini
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 변수 처리 @sirini
if(is_array($_GET)) {
	if($_GET['id']) $id = $_GET['id'];
	if($_GET['articleNo']) $articleNo = (int)$_GET['articleNo'];
	if($_GET['commentNo']) $commentNo = (int)$_GET['commentNo'];
	if($_GET['page']) $page = (int)$_GET['page'];
	if($_GET['alreadyEnterPassword']) $alreadyEnterPassword = $_GET['alreadyEnterPassword'];
	if($_GET['targetTable']) $targetTable = $_GET['targetTable'];
	if($_GET['readyWork']) $readyWork = $_GET['readyWork'];
	if($_GET['isReported']) $isReported = 1;
	if($_POST['clickCategory']) $clickCategory = $_POST['clickCategory'];
}
if($_SESSION['no']) $sessionNo = $_SESSION['no']; else $sessionNo = 0;
if($readyWork == 'c_delete') $addAction = '&articleNo='.$articleNo; else $addAction = '';

// 원 게시물을 조회한다. @sirini
if($targetTable == 'bbs') $valueNum = $articleNo; else $valueNum = $commentNo;
$data = $GR->getArray("select * from {$dbFIX}{$targetTable}_{$id} where no = '$valueNum'");

// 이 게시판 마스터일 경우 @sirini
$isMaster = 0;
$getMasters = $GR->getArray('select master, fix_time, theme from '.$dbFIX.'board_list where id = \''.$id.'\'');
if($getMasters[0]) {
	$masterArr = explode('|', $getMasters[0]);
	$masterNum = count($masterArr);
	for($m=0; $m<$masterNum; $m++) {
		if($_SESSION['mId'] && $_SESSION['mId'] == $masterArr[$m]) {
			$isMaster = 1; break;
		}
	}
}

// 글 삭제전 스킨 인클루드 @sirini
@include 'theme/'.$getMasters['theme'].'/theme_delete.php';

// 삭제를 실행한 주체가 관리자나 마스터라면 삭제시킨다. @sirini
if(($_SESSION['no'] == 1) || $isMaster) {
	if($targetTable == 'bbs') {
		$GR->query("delete from {$dbFIX}bbs_{$id} where no = '$articleNo'");
		$GR->query("delete from {$dbFIX}comment_{$id} where board_no = '$articleNo'");
		$files = $GR->getArray("select * from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'");
		if($files['no']) {
			for($f=1; $f<11; $f++) {
				$fileRoute = 'file_route'.$f;
				if($files[$fileRoute]) @unlink($files[$fileRoute]); 
			}
		}
		$GR->query('delete from '.$dbFIX.'pds_list where type = 0 and uid = '.$files['no']);
		$GR->query("delete from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'");
		$GR->query("delete from {$dbFIX}total_article where id = '$id' and article_num = '$articleNo'");
		$GR->query("delete from {$dbFIX}total_comment where id = '$id' and article_num = '$articleNo'");

		$getExtendFiles = $GR->query('select no, file_route from '.$dbFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo);
		while($extFiles = $GR->fetch($getExtendFiles)) {
			@unlink($extFiles['file_route']);
			$GR->query('delete from '.$dbFIX.'pds_list where type = 1 and uid = '.$extFiles['no']);
		}
		$GR->query("delete from {$dbFIX}pds_extend where id = '$id' and article_num = '$articleNo'");
	} else {
		$GR->query("delete from {$dbFIX}comment_{$id} where no = '$commentNo'");
		$GR->query("update {$dbFIX}bbs_{$id} set comment_count = comment_count - 1 where no = '$articleNo'");
		$GR->query("delete from {$dbFIX}total_comment where id = '$id' and comment_num = '$commentNo'");
	}
	if($isReported) {
		$GR->query("update {$dbFIX}report set status = 2 where no = ".$isReported);
		
		// 글삭제 하단 스킨 인클루드 @sirini
		@include 'theme/'.$getMasters['theme'].'/theme_delete_foot.php';
		$GR->error('신고된 게시물을 정상적으로 삭제하였습니다.', 0, 'CLOSE');
	}
	$GR->query("delete from {$dbFIX}article_option where id = '$id' and article_num = '$articleNo'");
	
	// 글삭제 하단 스킨 인클루드 @sirini
	@include 'theme/'.$getMasters['theme'].'/theme_delete_foot.php';
	
	if($targetTable == 'comment') {
		$GR->error('글이 정상적으로 삭제되었습니다', 0, 'board.php?id='.$id.'&articleNo='.$articleNo.$addAction);
	} else {
		$GR->error('글이 정상적으로 삭제되었습니다', 0, 'board.php?id='.$id.'&page='.$page.$addAction);	
	}
}
// 멤버나 손님이 남긴 글일 때 @sirini
else {
	if($getMasters['fix_time']) {
		$possibleTime = $data['signdate'] + (3600 * $getMasters['fix_time']);
		if($possibleTime < time()) $GR->error($getMasters['fix_time'].'시간 이상 지난 게시물은 삭제할 수 없습니다.', 0, 'board.php?id='.$id.'&articleNo='.$articleNo.'&page='.$page);
	}

	// 멤버가 남긴 글일 때 @sirini
	if($data['member_key']) {
		if($data['member_key'] == $sessionNo) {
			if($targetTable == 'bbs') {
				$GR->query("delete from {$dbFIX}bbs_{$id} where no = '$articleNo'") or 
					$GR->error('게시물을 삭제하지 못했습니다.', 1, 'board.php?id='.$id.'&page='.$page);
				$GR->query("delete from {$dbFIX}comment_{$id} where board_no = '$articleNo'");
				$files = $GR->getArray("select * from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'");
				if($files['no']) {
					for($f=1; $f<11; $f++) {
						$fileRoute = 'file_route'.$f;
						if($files[$fileRoute]) @unlink($files[$fileRoute]); 
					}
				}
				$GR->query('delete from '.$dbFIX.'pds_list where type = 0 and uid = '.$files['no']);
				$GR->query("delete from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'");
				$GR->query("delete from {$dbFIX}total_article where id = '$id' and article_num = '$articleNo'");
				$GR->query("delete from {$dbFIX}total_comment where id = '$id' and article_num = '$articleNo'");

				$getExtendFiles = $GR->query('select no, file_route from '.$dbFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo);
				while($extFiles = $GR->fetch($getExtendFiles)) {
					@unlink($extFiles['file_route']);
					$GR->query('delete from '.$dbFIX.'pds_list where type = 1 and uid = '.$extFiles['no']);
				}
				$GR->query("delete from {$dbFIX}pds_extend where id = '$id' and article_num = '$articleNo'");
			} else {
				$GR->query("delete from {$dbFIX}comment_{$id} where no = '$commentNo'");
				$GR->query("update {$dbFIX}bbs_{$id} set comment_count = comment_count - 1 where no = '$articleNo'");
				$GR->query("delete from {$dbFIX}total_comment where id = '$id' and comment_num = '$commentNo'");
			}
			$GR->query("delete from {$dbFIX}article_option where id = '$id' and article_num = '$articleNo'");
			
			// 글삭제 하단 스킨 인클루드 @sirini
			@include 'theme/'.$getMasters['theme'].'/theme_delete_foot.php';
			$GR->error('게시물이 정상적으로 삭제되었습니다', 0, 'board.php?id='.$id.'&page='.$page);
		} else $GR->error('자신이 남긴 글이 아닐경우 삭제할 수 없습니다.', 0, 'board.php?id='.$id.'&page='.$page.'&articleNo='.$articleNo);

	// 비회원이 남긴 글일때 @sirini
	} else {
		if($alreadyEnterPassword) {
			if($targetTable == 'bbs') $valueNo = $articleNo; else $valueNo = $commentNo;
			$getOldPass = $GR->query("select password from {$dbFIX}{$targetTable}_{$id} where no = '$valueNo'");
			$tFetchPass = $GR->fetch($getOldPass);
			if($alreadyEnterPassword == sha1($tFetchPass['password'])) {
				if($targetTable == 'bbs') {
					$GR->query("delete from {$dbFIX}bbs_{$id} where no = '$articleNo'");
					$GR->query("delete from {$dbFIX}comment_{$id} where board_no = '$articleNo'");
					$files = $GR->getArray("select * from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'");
					if($files['no']) {
						for($f=1; $f<11; $f++) {
							$fileRoute = 'file_route'.$f;
							if($files[$fileRoute]) @unlink($files[$fileRoute]); 
						}
					}
					$GR->query('delete from '.$dbFIX.'pds_list where type = 0 and uid = '.$files['no']);
					$GR->query("delete from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'");
					$GR->query("delete from {$dbFIX}total_article where id = '$id' and article_num = '$articleNo'");
					$GR->query("delete from {$dbFIX}total_comment where id = '$id' and article_num = '$articleNo'");

					$getExtendFiles = $GR->query('select no, file_route from '.$dbFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo);
					while($extFiles = $GR->fetch($getExtendFiles)) {
						@unlink($extFiles['file_route']);
						$GR->query('delete from '.$dbFIX.'pds_list where type = 1 and uid = '.$extFiles['no']);
					}
					$GR->query("delete from {$dbFIX}pds_extend where id = '$id' and article_num = '$articleNo'");
				}
				else
				{
					$GR->query("delete from {$dbFIX}comment_{$id} where no = '$commentNo'");
					$GR->query("update {$dbFIX}bbs_{$id} set comment_count = comment_count - 1 where no = '$articleNo'");
					$GR->query("delete from {$dbFIX}total_comment where id = '$id' and comment_num = '$commentNo'");
				}
				$GR->query("delete from {$dbFIX}article_option where id = '$id' and article_num = '$articleNo'");

				// 글삭제 하단 스킨 인클루드 @sirini
				@include 'theme/'.$getMasters['theme'].'/theme_delete_foot.php';
				$GR->error('글이 정상적으로 삭제되었습니다.', 0, 'board.php?id='.$id.'&page='.$page.$addAction);
			}
			else $GR->error('입력하셨던 패스워드로 게시물에 접근하지 못했습니다.', 0, 'board.php?id='.$id.'&page='.$page);
		}
		else {
			$GR->move('enter_password.php?id='.$id.'&articleNo='.$articleNo.'&commentNo='.$commentNo.'&readyWork='.
				$readyWork.'&targetTable='.$targetTable.'&page='.$page.'&clickCategory='.$clickCategory);
		}
	}
}
?>