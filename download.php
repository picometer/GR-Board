<?php
// 기본 클래스를 부른다 @sirini
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 기본 변수를 받아온다. @sirini
if($_GET['id']) $id = $_GET['id'];
if($_GET['articleNo']) $articleNo = (int)$_GET['articleNo'];
if($_GET['num']) $num = (int)$_GET['num'];
$filename = 'file_route'.$num;
if($_GET['extNo']) $extNo = (int)$_GET['extNo'];
$grboard = str_replace('/'.end(explode('/', $_SERVER['REQUEST_URI'])), '', $_SERVER['REQUEST_URI']);

// 정상적으로 접근해서 파일을 받는건지 확인한다. @sirini
if(!preg_match('|'.$_SERVER['HTTP_HOST'].'|i', $_SERVER['HTTP_REFERER'])) {
	$GR->error('정상적으로 파일을 다운로드 받으세요.');
}

// 로그인 되었을 때 @sirini
if($_SESSION['no']) {
	$sessionNo = (int)$_SESSION['no'];
	$tmpFetch = $GR->getArray('select level from '.$dbFIX.'member_list where no = \''.$sessionNo.'\'');
	$visitorLevel = $tmpFetch['level'];
	if($_SESSION['no'] == 1) $isAdmin = 1; else $isAdmin = 0;
	$isMember = 1;
	$getMasters = $GR->getArray('select master, group_no from '.$dbFIX.'board_list where id = \''.$id.'\'');
	
	// 게시판 관리자 @sirini
	if($getMasters[0]) {
		$masterArr = explode('|', $getMasters[0]);
		$masterNum = count($masterArr);
		for($m=0; $m<$masterNum; $m++) {
			if($_SESSION['mId'] && $_SESSION['mId'] == $masterArr[$m]) {
				$isAdmin = 1; break;
			}
		}
	}
	
	// 그룹 관리자 @sirini
	if($getMasters[1]) {
		$getGroupMaster = $GR->getArray('select master from '.$dbFIX.'group_list where no = '.$getMasters[1]);
		$groupMaster = explode('|', $getGroupMaster[0]);
		$cntResult = count($groupMaster);
		for($g=0; $g<$cntResult; $g++) {
			if($_SESSION['mId'] && $_SESSION['mId'] == $groupMaster[$g]) {
				$isAdmin = 1; break;
			}
		}
	}
} else { 
	$sessionNo = 0;
	$visitorLevel = 1; 
	$isAdmin = 0;
	$isMember = 0;
}

// 다운로드 권한 체크 @sirini
$getPostWriter = $GR->getArray('select member_key from '.$dbFIX.'bbs_'.$id.' where no = '.$articleNo.' limit 1');
if(!$getPostWriter['member_key']) $getPostWriter['member_key'] = -1;
$tmpFetchBoard = $GR->getArray('select * from '.$dbFIX.'board_list where id = \''.$id.'\'');
if(!$isAdmin && ($getPostWriter['member_key'] != $sessionNo) && ($tmpFetchBoard['view_level'] > $visitorLevel || $tmpFetchBoard['down_level'] > $visitorLevel)) {
	$grboard = str_replace('/'.end(explode('/', $_SERVER['REQUEST_URI'])), '', $_SERVER['REQUEST_URI']);
	$GR->error('다운로드 권한이 없습니다.', 0, $grboard.'/board.php?id='.$id.'&articleNo='.$articleNo);
}

// 포인트 차감 @sirini
if(!$isAdmin && ($getPostWriter['member_key'] != $sessionNo) && $tmpFetchBoard['down_point']) {
	if($visitorLevel < 2) $GR->error('로그인 후 받으실 수 있습니다.', 0, $grboard.'/board.php?id='.$id.'&articleNo='.$articleNo);
	$getVisitorInfo = $GR->getArray('select id, point from '.$dbFIX.'member_list where no = '.$sessionNo);
	if($getVisitorInfo['point'] < $tmpFetchBoard['down_point']) {
		$GR->error('포인트를 더 쌓으신 후에 받으실 수 있습니다.', 0, $grboard.'/board.php?id='.$id.'&articleNo='.$articleNo);
	}
	$GR->query('update '.$dbFIX.'member_list set point = point - '.$tmpFetchBoard['down_point'].' where no = '.$sessionNo);
	$GR->query("insert into {$dbFIX}memo_save set no = '', member_key = '$sessionNo', sender_key = 1, ".
		"subject = '[자동알림] ".$tmpFetchBoard['down_point']." 포인트를 사용 하셨습니다.', content = '<a href=\"".$grboard."/board.php?id=".$id."&articleNo=".$articleNo."\" onclick=\"window.open(this.href, \'_blank\'); return false\">이 곳</a>에서 파일 다운로드에 ".$tmpFetchBoard['down_point']." 포인트를 사용하셨습니다.', signdate = '".$GR->grTime()."', is_view = '0'");
}

// 추가 파일 다운로드 시 바로 처리 @sirini
if($extNo) {
	$temp = $GR->getArray('select file_route from '.$dbFIX.'pds_extend where no = '.$extNo);
	$fileDownload = str_replace('%2F', '/', urlencode($temp['file_route']));
	$getPdsList = $GR->getArray('select no, name from '.$dbFIX.'pds_list where type = 1 and uid = '.$extNo);
	$realFilename = str_replace('%2F', '/', urlencode($getPdsList['name']));
	if($getPdsList['no']) {
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: public');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename='.end(explode('/', $realFilename)).';');
		header('Content-Transfer-Encoding: binary');
		header('Content-Type: application/octet-stream');
		header('Content-Length: '.filesize($fileDownload));
		ob_clean();
		flush();
		@readfile($fileDownload);
	} else {
		header('location:'.$fileDownload);
	}
}

// 일반 다운로드시 처리하고, 받은 수 올려주기 @sirini
else {
	$temp = $GR->getArray("select no, {$filename} from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'");
	$fileDownload = str_replace('%2F', '/', urlencode($temp[$filename]));
	$getPdsList = $GR->getArray('select no, name from '.$dbFIX.'pds_list where type = 0 and uid = '.$temp['no'].' and idx = '.($num-1).' limit 1');
	$realFilename = str_replace('%2F', '/', urlencode($getPdsList['name']));
	if($getPdsList['no']) {
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: public');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename='.end(explode('/', $realFilename)).';');
		header('Content-Transfer-Encoding: binary');
		header('Content-Type: application/octet-stream');
		header('Content-Length: '.filesize($fileDownload));
		ob_clean();
		flush();
		@readfile($fileDownload);
	} else {
		header('location:'.$fileDownload);
	}
	$GR->query("update {$dbFIX}pds_save set hit=hit+1 where id = '$id' and article_num = '$articleNo'");
}
?>