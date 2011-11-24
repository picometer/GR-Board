<?php 
// 기본 클래스 @sirini
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 변수 처리 @sirini
if(isset($_GET['modifyNo'])) $modifyNo = $_GET['modifyNo'];
if(isset($_POST['modifyNo'])) $modifyNo = $_POST['modifyNo'];
if(!isset($modifyNo)) $modifyNo = false;
if(isset($_GET['deleteNo'])) $deleteNo = $_GET['deleteNo']; else $deleteNo = false;
if(isset($_POST['mode'])) $mode = $_POST['mode']; else $mode = false;
@extract($_POST);

// 관리자인지 확인한다. @sirini
if($_SESSION['no'] != 1) $GR->error('관리자 화면은 관리자만 접근할 수 있습니다.', 1, 'CLOSE');

// 지정된 opt 값에 맞는 var 를 가져오기 @sirini
function getVar($opt) {
	global $dbFIX, $GR;
	$result = $GR->getArray('select var from '.$dbFIX.'layout_config where opt = \''.$opt.'\'');
	return ($result[0]) ? $result[0] : false;
}

// 지정된 opt, var 값을 저장하기 @sirini
function setVar($opt, $var) {
	global $dbFIX, $GR;
	$getExist = $GR->getArray('select no from '.$dbFIX.'layout_config where opt = \''.$opt.'\'');
	if($getExist['no']) $GR->query("update {$dbFIX}layout_config set var = '$var' where no = ".$getExist['no']);
	else $GR->query("insert into {$dbFIX}layout_config set no = '', opt = '$opt', var = '$var'");
}

// 공통 설정 저장 @sirini
if($_POST['setCommon']) {
	setVar('theme', $theme);
	setVar('title', $title);
	setVar('outlogin', $outlogin);
	setVar('useOutlogin', $useOutlogin);
	setVar('latest', $latest);
	setVar('useLatest', $useLatest);
	setVar('poll', $poll);
	setVar('usePoll', $usePoll);
	setVar('latestNum', $latestNum);
	setVar('useLayout', $useLayout);
	if($showBoard) {
		$showBoards = '';
		$selectTheme = getVar('theme');
		for($i=0; $i<count($showBoard); $i++) {
			$GR->query("update {$dbFIX}board_list set head_file = 'layout/{$selectTheme}/head.board.php', foot_file = 'layout/{$selectTheme}/foot.board.php' where id = '".$showBoard[$i]."'");
			$showBoards .= $showBoard[$i].'|';
		}
		setVar('showBoard', $showBoards);
	}
	if($_FILES['logo']['size'] > 0) {
		if(!is_uploaded_file($_FILES['logo']['tmp_name'])) $GR->error('정상적으로 파일을 업로드 해 주세요.', 0, 'HISTORY_BACK');
		if(!preg_match('/\.jpg|\.gif|\.png|\.bmp/i', $_FILES['logo']['name'])) $GR->error('그림 파일이 아니면 업로드가 불가능 합니다. (허용파일: .jpg, .gif, .png, .bmp.', 0, 'HISTORY_BACK');
		$_FILES['logo']['tmp_name'] = str_replace('\\\\', '\\', $_FILES['logo']['tmp_name']);
		$getFileType = explode('.', $_FILES['logo']['name']);
		$lastDot = $getFileType[count($getFileType)-1];
		$filename = 'logo.'.$lastDot;
		if(file_exists('index/image/'.$filename)) @unlink('index/image/'.$filename);
		$saveRoute = 'index/image/'.$filename;
		if(!move_uploaded_file($_FILES['logo']['tmp_name'], $saveRoute)) $GR->error('파일을 업로드 하지 못했습니다. 파일용량을 확인해 보세요.', 0, 'HISTORY_BACK');
		setVar('logo', $saveRoute);
	}
	if($_FILES['mainImage']['size'] > 0) {
		if(!is_uploaded_file($_FILES['mainImage']['tmp_name'])) $GR->error('정상적으로 파일을 업로드 해 주세요.', 0, 'HISTORY_BACK');
		if(!preg_match('/\.jpg|\.gif|\.png|\.bmp/i', $_FILES['mainImage']['name'])) $GR->error('그림 파일이 아니면 업로드가 불가능 합니다. (허용파일: .jpg, .gif, .png, .bmp.', 0, 'HISTORY_BACK');
		$_FILES['mainImage']['tmp_name'] = str_replace('\\\\', '\\', $_FILES['mainImage']['tmp_name']);
		$getFileType = explode('.', $_FILES['mainImage']['name']);
		$lastDot = $getFileType[count($getFileType)-1];
		$filename = 'mainImage.'.$lastDot;
		if(file_exists('index/image/'.$filename)) @unlink('index/image/'.$filename);
		$saveRoute = 'index/image/'.$filename;
		if(!move_uploaded_file($_FILES['mainImage']['tmp_name'], $saveRoute)) $GR->error('파일을 업로드 하지 못했습니다. 파일용량을 확인해 보세요.', 0, 'HISTORY_BACK');
		setVar('mainImage', $saveRoute);
	}
	$GR->error('설정값을 수정했습니다.', 0, 'admin_layout.php?v=9');
}

// 메뉴 삭제
if($_GET['deleteMenu']) {
	$GR->query('delete from '.$dbFIX.'layout_config where no = '.$_GET['deleteMenu']);
	$GR->error('선택한 항목을 삭제하였습니다.', 0, 'admin_layout.php?v=9');
}

// 상단 메뉴 처리
if($_POST['setTopMenu']) {
	//$var = m.ysql_real_escape_string($addMenuName).'|'.$addMenuLink;
	$var = $addMenuName.'|'.$addMenuLink; //!!!확인필요
	if($modifyTarget) $GR->query("update {$dbFIX}layout_config set var = '$var' where no = '$modifyTarget'");
	else $GR->query("insert into {$dbFIX}layout_config set no = '', opt = 'topmenu', var = '$var'");
	$GR->error('상단 메뉴를 수정하였습니다.', 0, 'admin_layout.php?v=9#topmenuSetting');
}

// 사이드 메뉴 처리
if($_POST['setSideMenu']) {
	//$var = m.ysql_real_escape_string($addMenuName).'|'.$addMenuLink;
	$var = $addMenuName.'|'.$addMenuLink; //!!!확인필요
	if($modifyTarget) $GR->query("update {$dbFIX}layout_config set var = '$var' where no = '$modifyTarget'");
	else $GR->query("insert into {$dbFIX}layout_config set no = '', opt = 'sidemenu', var = '$var'");
	$GR->error('사이드 메뉴를 수정하였습니다.', 0, 'admin_layout.php?v=9#sidemenuSetting');
}

// 페이지 처리
if($_POST['setPage']) {
	$getExistID = $GR->getArray('select no from '.$dbFIX.'layout_config where var like \''.$id.'|%\'');
	$var = $id.'|'.$content;
	if($getExistID['no'] && $modifyTarget) $GR->query("update {$dbFIX}layout_config set var = '$var' where no = '$modifyTarget'");
	else $GR->query("insert into {$dbFIX}layout_config set no = '', opt = 'page', var = '$var'");
	$GR->error($id.' 문서를 작성 하였습니다.', 0, 'admin_layout.php?v=9#pageSetting');
}

// 그룹 정보 변경시 기존 정보 가져오기
if($modifyNo) $modify = $GR->getArray('select * from '.$dbFIX.'member_group where no = '.$modifyNo);

// 문서설정
$title = 'GR Board Admin Page ( Layout Manager )';
include 'html_head.php';
include 'admin/admin_left_menu.php';
?>
		<!-- 현재 페이지 도움말 -->
		<div id="grboardHelpBox">
			GR Board 에서 쉬운 홈페이지 제작을 위한 레이아웃 매니져 설정 화면 입니다. <a href="#" title="도움말을 더 봅니다" id="helpLayoutBtn">...도움말보기 <img src="image/admin/btn_help_more.gif" alt="더 보기" /></a>
			<div id="helpBox" style="display: none">
			GR Board v1.7.5 부터 /grboard/index/ 를 통해서 웹사이트가 내장되어 제공 됩니다.<br />
			기존의 HTML 을 직접 작성하면서 GR Board 를 활용하여 웹사이트를 만드는 방법 이외에도,<br />
			간단한 설정값을 통해서 바로 사용 가능한 웹사이트를 쉽게 만드실 수 있도록 지원하고 있습니다.<br />
			아래에 나와 있는 설정값들을 작성(혹은 선택)하고 확인버튼을 누르신 후<br />
			http://<?php echo $_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']); ?>/index/ 에 방문하여 완성된 웹사이트를 보실 수 있습니다.<br />
			<br />
			레이아웃 매니저를 통해서 생성되는 웹사이트는 /grboard/layout/<br />
			아래에 있는 테마중 선택된 테마를 통해서 보여지게 됩니다.<br />
			어느 정도 정해진 형식 내에서 아래 설정값들을 적용한 화면이 출력 됩니다.<br />
			만약 선택하신 레이아웃 테마를 직접 수정하고자 하실 경우(예: basic) /grboard/layout/basic/ 의 위치에서<br />
			각 파일들을 필요에 맞게 직접 HTML 수정을 통해서 변경하실 수 있습니다.<br />
			</div>
		</div><!--# 현재 페이지 도움말 -->

		<!-- 기본 레이아웃 설정 -->
		<div class="mvBack" id="admLayoutConfig">
			<div class="mv">레이아웃 설정</div>

			<form id="layout" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
			<div><input type="hidden" name="setCommon" value="1" /></div>

			<div class="tableListLine" id="useLayoutFunction">
				<div class="tableLeft" title="/grboard/index/ 로 접근시 layout 기능을 사용할 것인지 정합니다.">사용여부 선택</div>
				<div class="tableRight">
					<input type="radio" name="useLayout" id="layoutYes" value="1"<?php echo getVar('useLayout')?' checked="checked"':''; ?> /> <label for="layoutYes">사용함</label> &nbsp;&nbsp;
					<input type="radio" name="useLayout" id="layoutNo" value="0"<?php echo !getVar('useLayout')?' checked="checked"':''; ?> /> <label for="layoutNo">사용안함</label> &nbsp;&nbsp;
					<input type="image" src="image/admin/btn_ok.gif" class="btn" title="이 설정을 적용 합니다." /></div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="사용할 레이아웃 템플릿을 선택합니다">레이아웃 템플릿</div>
				<div class="tableRight">
					<select name="theme">
						<?php
						$ot = @opendir('layout/');
						$layout = getVar('theme');
						while($rt = @readdir($ot)) {
							if($rt == '.' or $rt == '..') continue;
							echo '<option value="'.$rt.'"'.(($layout==$rt)?' selected="selected"':'').'>'.$rt.'</option>';
						}
						?>
					</select>
					<a href="http://<?php echo $_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']); ?>/index/" class="popup">[미리보기]</a>
					<a href="layout/<?php echo $layout; ?>/readme.txt"class="popup">[제작자 설명보기]</a>
					(보여줄 레이아웃 템플릿 선택) <input type="image" src="image/admin/btn_ok.gif" class="btn" title="이 설정을 적용 합니다." />
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="브라우저 최상단에 보여질 사이트 제목(혹은 이름)을 입력합니다">사이트 제목</div>
				<div class="tableRight"><input type="text" name="title" value="<?php echo getVar('title'); ?>" class="input" style="width: 300px" /> (브라우저 최상단에 보여질 제목) <input type="image" src="image/admin/btn_ok.gif" class="btn" title="이 설정을 적용 합니다." /></div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="사이트 상단에 보여질 로고를 업로드 합니다">사이트 로고</div>
				<div class="tableRight"><input type="file" name="logo" class="input" /> (사이트 상단에 보여질 로고 업로드) <input type="image" src="image/admin/btn_ok.gif" class="btn" title="이 설정을 적용 합니다." /><?php if(getVar('logo')) { ?><br /><img src="<?php echo getVar('logo'); ?>" alt="미리보기" /><?php } if(!is_writable('index/image/')) echo '<br /><span class="badStatus">[!] /index/image/ 에 접근불가. FTP 프로그램을 통해 /index/ 와 /index/image/ 폴더 퍼미션을 707로 변경해 주세요!</span>'; ?></div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="사이트 중간에 보여질 메인 이미지를 업로드 합니다">메인 이미지</div>
				<div class="tableRight"><input type="file" name="mainImage" class="input" /> (사이트 중간에 보여질 그림 업로드) <input type="image" src="image/admin/btn_ok.gif" class="btn" title="이 설정을 적용 합니다." /><?php if(getVar('mainImage')) { ?><br /><img src="<?php echo getVar('mainImage'); ?>" alt="미리보기" /><?php } if(!is_writable('index/image/')) echo '<br /><span class="badStatus">[!] /index/image/ 에 접근불가. FTP 프로그램을 통해 /index/ 와 /index/image/ 폴더 퍼미션을 707로 변경해 주세요!</span>'; ?></div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine" id="outloginSetting">
				<div class="tableLeft" title="외부로그인 테마를 선택합니다">외부로그인 선택</div>
				<div class="tableRight">
					<select name="outlogin">
						<?php
						$ot = @opendir('outlogin/');
						while($rt = @readdir($ot)) {
							if($rt == '.' or $rt == '..') continue;
							echo '<option value="'.$rt.'"'.((getVar('outlogin')==$rt)?' selected="selected"':'').'>'.$rt.'</option>';
						}
						$outlogin = getVar('useOutlogin');
						?>
					</select>
					<input type="radio" name="useOutlogin" id="oYes" value="1"<?php echo ($outlogin)?' checked="checked"':''; ?> /> <label for="oYes">외부로그인 사용함</label> &nbsp;&nbsp;
					<input type="radio" name="useOutlogin" id="oNo" value="0"<?php echo (!$outlogin)?' checked="checked"':''; ?> /> <label for="oNo">외부로그인 사용안함</label> &nbsp;&nbsp;
					<input type="image" src="image/admin/btn_ok.gif" class="btn" title="이 설정을 적용 합니다." /></div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine" id="latestArticleSetting">
				<div class="tableLeft" title="최근게시물 테마를 선택합니다">최근게시물 선택</div>
				<div class="tableRight">
					<select name="latest">
						<?php
						$ot = @opendir('latest/');
						while($rt = @readdir($ot)) {
							if($rt == '.' or $rt == '..') continue;
							echo '<option value="'.$rt.'"'.((getVar('latest')==$rt)?' selected="selected"':'').'>'.$rt.'</option>';
						}
						$latestArticle = getVar('useLatest');
						?>
					</select>
					<input type="radio" name="useLatest" id="lYes" value="1"<?php echo ($latestArticle)?' checked="checked"':''; ?> /> <label for="lYes">최근게시물 사용함</label> &nbsp;&nbsp;
					<input type="radio" name="useLatest" id="lNo" value="0"<?php echo (!$latestArticle)?' checked="checked"':''; ?>  /> <label for="lNo">최근게시물 사용안함</label> &nbsp;&nbsp;
					<input type="image" src="image/admin/btn_ok.gif" class="btn" title="이 설정을 적용 합니다." />
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="하나의 최근게시물당 게시물을 몇 개씩 보이도록 할 것인지 지정">최근게시물 목록수</div>
				<div class="tableRight"><input type="text" name="latestNum" class="input" value="<?php echo (getVar('latestNum'))?getVar('latestNum'):'5'; ?>" /> (하나의 최근게시물당 게시물을 몇 개씩 보일 것인지 지정, 기본: 5)
				<input type="image" src="image/admin/btn_ok.gif" class="btn" title="이 설정을 적용 합니다." /></div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine" id="latestPollSetting">
				<div class="tableLeft" title="최근설문 테마를 선택합니다">최근설문 선택</div>
				<div class="tableRight">
					<select name="poll">
						<?php
						$ot = @opendir('latest/');
						while($rt = @readdir($ot)) {
							if($rt == '.' or $rt == '..') continue;
							echo '<option value="'.$rt.'"'.((getVar('poll')==$rt)?' selected="selected"':'').'>'.$rt.'</option>';
						}
						$latestPoll = getVar('usePoll');
						?>
					</select>
					<input type="radio" name="usePoll" id="pYes" value="1"<?php echo ($latestPoll)?' checked="checked"':''; ?> /> <label for="pYes">최근설문 사용함</label> &nbsp;&nbsp;
					<input type="radio" name="usePoll" id="pNo" value="0"<?php echo (!$latestPoll)?' checked="checked"':''; ?> /> <label for="pNo">최근설문 사용안함</label> &nbsp;&nbsp;
					<input type="image" src="image/admin/btn_ok.gif" class="btn" title="이 설정을 적용 합니다." />
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine" id="useBoardSetting">
				<div class="tableLeft" title="첫화면에 최근게시물로 보여질 게시판들을 선택 합니다">보일 게시판 선택</div>
				<div class="tableRight">
					<div class="grayBox">아래 선택된 게시판들은 /grboard/index/ 첫화면에서 최근게시물로 보여질 게시판들 입니다.<br />
					선택된 게시판들의 상단과 하단 HTML 파일은 /grboard/layout/<?php echo $layout; ?>/ 안에 있는<br />
					<span style="color: green">head.board.php</span> 와 <span style="color: green">foot.board.php</span> 로 자동 변경 됩니다.<br />
					만약 첫화면에서 최근게시물로 출력하지는 않지만, 메뉴를 클릭할 시 보여질 게시판이 있으시다면<br />
					해당 게시판의 설정화면에서 <strong>상단 파일</strong> 과 <strong>하단 파일</strong> 에 아래와 같이 각각<br />
					작성해 주셔야 합니다.<br />
					※ 상단 파일: <span style="color: green">layout/<?php echo $layout; ?>/head.board.php</span><br />
					※ 하단 파일: <span style="color: green">layout/<?php echo $layout; ?>/foot.board.php</span><br /></div>
					<?php
					$ot = $GR->query('select id from '.$dbFIX.'board_list');
					while($rt = $GR->fetch($ot)) {
						echo '<input type="checkbox" name="showBoard[]" value="'.$rt['id'].'"'.((@ereg($rt['id'].'\|', getVar('showBoard')))?' checked="checked"':'').' />'.$rt['id'].'&nbsp;&nbsp;&nbsp;&nbsp;';
					}
					$latestPoll = getVar('usePoll');
					?>
					<input type="image" src="image/admin/btn_ok.gif" class="btn" title="이 설정을 적용 합니다." />
				</div>
				<div class="clear"></div>
				</form>
			</div>
			
			<form id="topmenu" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
			<div><?php 
			if($_GET['modifyTopMenu']) { 
				$getMenu = $GR->getArray('select var from '.$dbFIX.'layout_config where no = '.$_GET['modifyTopMenu']);
				$tmpArr = @explode('|', $getMenu['var']);
				$menuName = $tmpArr[0];
				$menuLink = $tmpArr[1];
			?><input type="hidden" name="modifyTarget" value="<?php echo $_GET['modifyTopMenu']; ?>" /><?php } ?>
			<input type="hidden" name="setTopMenu" value="1" /></div>
			<div class="tableListLine" id="topmenuSetting">
				<div class="tableLeft" title="사이트 상단에 보여질 메뉴를 관리합니다.">상단 메뉴</div>
				<div class="tableRight">
					<div class="grayBox"><strong>메뉴이름:</strong> <input type="text" name="addMenuName" class="input" value="<?php echo $menuName; ?>" /> <strong>링크주소:</strong> <input type="text" name="addMenuLink" class="input" value="<?php echo $menuLink; ?>" /> 
					<input type="image" src="image/admin/btn_add.gif" class="btn" title="상단 메뉴를 추가 혹은 수정 합니다." /><br /><br />
					※ 링크가 게시판(예: sample)을 향하게 하려면 <strong>링크주소</strong>에「../board.php?id=<span style="color: green">sample</span>」을 입력하세요.<br />
					※ 링크가 페이지(예: sample)을 향하게 하려면 <strong>링크주소</strong>에「../page.php?id=<span style="color: brown">sample</span>」을 입력하세요.<br />
					 (하단 "<span style="color: #296d98">페이지 관리</span>" 에서 추가한 페이지만 해당됩니다. 일반 문서는 http:// 로 시작하는 주소를 써 주세요.)<br /></div>
					<ol>
						<?php
						$getSideMenu = $GR->query('select no, var from '.$dbFIX.'layout_config where opt = \'topmenu\'');
						while($sides = $GR->fetch($getSideMenu)) { 
							$tmpArr = @explode('|', $sides['var']);
							$menuName = $tmpArr[0];
							$menuLink = $tmpArr[1];
						?>
						<li><a href="<?php echo $menuLink; ?>"><?php echo $menuName; ?></a> &nbsp;&nbsp; <a href="admin_layout.php?modifyTopMenu=<?php echo $sides['no']; ?>&amp;v=9" title="이 항목을 수정하고자 하신다면 클릭하세요.">(수정)</a>
						<a href="#" onclick="deleteMenu(<?php echo $sides['no']; ?>);" title="이 항목을 삭제 하고자 하신다면 클릭하세요.">(삭제)</a></li>
						<?php } ?>
					</ol>
				</div>
				<div class="clear"></div>
				</form>
			</div>
			
			<form id="sidemenu" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
			<div><?php 
			if($_GET['modifySideMenu']) { 
				$getMenu = $GR->getArray('select var from '.$dbFIX.'layout_config where no = '.$_GET['modifySideMenu']);
				$tmpArr = @explode('|', $getMenu['var']);
				$menuName1 = $tmpArr[0];
				$menuLink1 = $tmpArr[1];
			?><input type="hidden" name="modifyTarget" value="<?php echo $_GET['modifySideMenu']; ?>" /><?php } ?>
			<input type="hidden" name="setSideMenu" value="1" /></div>
			<div class="tableListLine" id="sidemenuSetting">
				<div class="tableLeft" title="사이트 좌/우 에서 보여질 메뉴를 관리합니다.">사이드 메뉴</div>
				<div class="tableRight">
					<div class="grayBox"><strong>메뉴이름:</strong> <input type="text" name="addMenuName" class="input" value="<?php echo $menuName1; ?>" /> <strong>링크주소:</strong> <input type="text" name="addMenuLink" class="input" value="<?php echo $menuLink1; ?>" /> 
					<input type="image" src="image/admin/btn_add.gif" class="btn" title="사이드 메뉴를 추가 혹은 수정 합니다." /><br /><br />
					※ 링크가 게시판(예: sample)을 향하게 하려면 <strong>링크주소</strong>에「../board.php?id=<span style="color: green">sample</span>」을 입력하세요.<br />
					※ 링크가 페이지(예: sample)을 향하게 하려면 <strong>링크주소</strong>에「../page.php?id=<span style="color: brown">sample</span>」을 입력하세요.<br />
					 (하단 "<span style="color: #296d98">페이지 관리</span>" 에서 추가한 페이지만 해당됩니다. 일반 문서는 http:// 로 시작하는 주소를 써 주세요.)<br /></div>
					<ol>
						<?php
						$getSideMenu = $GR->query('select no, var from '.$dbFIX.'layout_config where opt = \'sidemenu\'');
						while($sides = $GR->fetch($getSideMenu)) { 
							$tmpArr = @explode('|', $sides['var']);
							$menuName1 = $tmpArr[0];
							$menuLink1 = $tmpArr[1];
						?>
						<li><a href="<?php echo $menuLink1; ?>"><?php echo $menuName1; ?></a> &nbsp;&nbsp; <a href="admin_layout.php?modifySideMenu=<?php echo $sides['no']; ?>&amp;v=9" title="이 항목을 수정하고자 하신다면 클릭하세요.">(수정)</a>
						<a href="#" onclick="deleteMenu(<?php echo $sides['no']; ?>);" title="이 항목을 삭제 하고자 하신다면 클릭하세요.">(삭제)</a></li>
						<?php } ?>
					</ol>
				</div>
				<div class="clear"></div>
			</div>
			</form>

			<form id="pages" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
			<div><?php
			if($_GET['modifyPage']) {
				$getPage = $GR->getArray('select var from '.$dbFIX.'layout_config where no = '.$_GET['modifyPage']);
				$tmpArr = @explode('|', $getPage['var']);
				$pageTitle = $tmpArr[0];
				$pageContent = $tmpArr[1];
			?><input type="hidden" name="modifyTarget" value="<?php echo $_GET['modifyPage']; ?>" /><?php } ?>
			<input type="hidden" name="setPage" value="1" /></div>
			<div class="tableListLine" id="pageSetting">
				<div class="tableLeft" title="사이트 내에서 헤드 / 풋이 적용된 HTML 페이지를 작성 합니다.">페이지 관리</div>
				<div class="tableRight">
					<div class="grayBox">페이지 관리에서 작성한 문서는 ../page.php?id=<span style="color: green; font-weight: bold">id</span> 형태로 접속하게 되면<br />
					화면에 아래 작성한 문서가 출력되게 됩니다. 게시판과 마찬가지로, 아래 작성한 문서의 상단과 하단에는 <br />
					레이아웃이 적용되는데 <strong>상단:</strong> <span style="color: green">layout/<?php echo $layout; ?>/head.page.php</span>, <strong>하단:</strong> <span style="color: green">layout/<?php echo $layout; ?>/foot.page.php</span><br />
					과 같이 적용이 됩니다. 만약 아래 작성한 문서의 윗쪽 부분과 아래쪽 부분에 직접 HTML 수정을 원하실 경우,<br />
					위에 적혀진 경로의 파일을 메모장 등으로 열어서 직접 수정하실 수 있습니다.<br /></div>
					<div style="padding: 5px"><input type="text" name="id" value="<?php echo $pageTitle; ?>" class="input" /> (이 페이지 고유의 ID를 작성합니다. 영어+숫자 조합) <input type="image" src="image/admin/btn_add.gif" class="btn" title="페이지를 추가 혹은 수정 합니다." /></div>
					<div><textarea name="content" rows="20" style="width: 99%"><?php echo $pageContent; ?></textarea></div>
					<ol>
						<?php
						$getPages = $GR->query('select no, var from '.$dbFIX.'layout_config where opt = \'page\'');
						while($pgs = $GR->fetch($getPages)) { 
							$tmpArr = @explode('|', $pgs['var']);
						?>
						<li><a href="admin_layout.php?v=9&amp;modifyPage=<?php echo $pgs['no']; ?>#pageSetting"><?php echo $tmpArr[0]; ?></a> &nbsp;&nbsp; <a href="admin_layout.php?modifyPage=<?php echo $pgs['no']; ?>&amp;v=9" title="이 항목을 수정하고자 하신다면 클릭하세요.">(수정)</a>
						<a href="#" onclick="deleteMenu(<?php echo $pgs['no']; ?>);" title="이 항목을 삭제 하고자 하신다면 클릭하세요.">(삭제)</a></li>
						<?php } ?>
					</ol>
				</div>
				<div class="clear"></div>
			</div>
			</form>

		</div><!--# 우측 몸통 부분 -->

		<div class="clear"></div>

		</div><!--# 폭 설정 -->

	</div><!--# 가운데 정렬 -->

<script src="js/jquery.js"></script>
<script src="tiny_mce/tiny_mce.js"></script>
<script src="admin/admin_layout.js"></script>

</body>
</html>
