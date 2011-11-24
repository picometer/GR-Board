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

// 관리자인지 확인한다. @sirini
if($_SESSION['no'] != 1) $GR->error('관리자 화면은 관리자만 접근할 수 있습니다.', 1, 'CLOSE');

// 그룹 변경 처리 @sirini
if($mode == 'modify') {
	$que = "update {$dbFIX}group_list set name = '".$_POST['groupName']."', master = '".$_POST['master']."' where no = '".$modifyNo."'";
	@mysql_query($que);
	$GR->error('그룹 이름을 변경하였습니다.', 0, 'admin_group.php');

// 그룹 추가 처리 @sirini
} elseif($mode == 'add') {
	$que = "insert into {$dbFIX}group_list set no = '', name = '".$_POST['groupName']."', master = '".$_POST['master']."', make_time = '".time()."'";
	@mysql_query($que);
	$GR->error($_POST['groupName'] . ' 그룹을 추가하였습니다.', 0, 'admin_group.php');
}

// 그룹 삭제 처리 @sirini
if($deleteNo) {
	@mysql_query("delete from {$dbFIX}group_list where no = '$deleteNo'");
	@mysql_query("update {$dbFIX}board_list set group_no = '1' where group_no = '$deleteNo'");
	$GR->error('삭제했습니다. 해당 그룹에 속했던 게시판들은 모두 기본 그룹 소속이 됩니다.', 0, 'admin_group.php');
}

// 그룹 정보 변경시 기존 정보 가져오기 @sirini
if($modifyNo) $modify = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'group_list where no = '.$modifyNo));

// 문서설정 @sirini
$title = 'GR Board Admin Page ( Group )';
include 'html_head.php';
include 'admin/admin_left_menu.php';
?>
		<!-- 현재 페이지 도움말 -->
		<div id="grboardHelpBox">
			GR Board 게시판들을 그룹으로 묶어서 관리할 수 있도록 해 주는 페이지 입니다. <a href="#" title="도움말을 더 봅니다" id="helpGroupBtn">...도움말보기 <img src="image/admin/btn_help_more.gif" alt="더 보기" /></a>
			<div id="helpBox" style="display: none">
			GR Board 는 게시판들을 그룹으로 묶어서 관리 합니다.<br />
			최초 설치시부터 "<strong>일반</strong>" 이라는 그룹 속에서 게시판들이 생성되며,<br />
			해당 게시판의 설정을 수정할 때 보였던 "<strong>모두 동일</strong>" 은 해당 게시판이 속한 그룹 전체의<br />
			게시판들에 해당 항목을 동일하게 설정한다는 것을 뜻하는 것이었습니다.<br />
			게시판별로 특정 멤버들을 ID를 이용하여 게시판 관리자로 지정할 수 있듯이<br />
			그룹별로도 그룹 관리자를 지정할 수 있습니다.<br />
			멤버의 ID를 "<strong>그룹관리자:</strong>" 항목에 입력하시면 됩니다. (예: sirini|sexyguy|gunman)
			</div>
		</div><!--# 현재 페이지 도움말 -->

		<!-- 그룹 목록 -->
		<div class="mvBack" id="admGroupList">
			<div class="mv">그룹 목록</div>

			<table rules="none" summary="GR Board Group List" cellpadding="0" cellspacing="0" border="0" style="width: 100%">
			<caption></caption>
			<colgroup>
			<col style="width: 40px" />
			<col />
			<col style="width: 80px" />
			<col style="width: 80px" />
			<col style="width: 80px" />
			<col style="width: 70px" />
			<col style="width: 70px" />
			</colgroup>
			<thead>
			<tr>
				<th class="titleBar">번호</th>
				<th class="titleBar">그룹명</th>
				<th class="titleBar">게시판수</th>
				<th class="titleBar">마스터수</th>
				<th class="titleBar">생성일</th>
				<th class="titleBar">변경</th>
				<th class="titleBar">삭제</th>
			</tr>
			</thead>
			<tbody>
			<?php
			// 목록화 @sirini
			$getGroup = @mysql_query('select * from '.$dbFIX.'group_list');
			while($data = mysql_fetch_array($getGroup)) { ?>
			<tr>
				<td class="boardList"><?php echo $data['no']; ?></td>
				<td><?php echo $data['name']; ?></a></td>
				<td class="boardList">
				<?php
				// 이 그룹에 속한 게시판 개수 @sirini
				$getCntBoard = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'board_list where group_no = '.$data['no']));
				echo $getCntBoard[0];
				?>
				</td>
				<td class="boardList"><?php echo count(explode('|', $data['master'])); ?></td>
				<td class="boardList"><?php echo date('Y.m.d', $data['make_time']); ?></td>
				<td class="boardList"><a href="#" onclick="modifyGroup(<?php echo $data['no']; ?>);" title="선택한 그룹을 변경합니다."><img src="image/admin/admin_group_modify.gif" alt="변경하기" /></a></td>
				<td class="boardList"><a href="#" onclick="deleteGroup(<?php echo $data['no']; ?>);" title="선택한 그룹을 삭제합니다."><img src="image/admin/admin_group_delete.gif" alt="삭제하기" /></a></td>
			</tr>
			<?php } ?>
			</tbody>
			</table>
		</div><!--# 그룹 목록 -->

		<!-- 위아래 공백 -->
		<div class="vSpace"></div>

		<!-- 그룹 추가/변경 -->
		<form id="group_list" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return checkAddGroup(this);">
		<div><input type="hidden" name="mode" value="<?php echo ($modifyNo)?'modify':'add'; ?>" />
		<input type="hidden" name="modifyNo" value="<?php echo $modifyNo; ?>" /></div> 
		<div class="mvBack" id="admGroupAdd">
			<div class="mv">그룹 <?php echo ($modifyNo)?'변경':'추가'; ?></div>
			
			<div class="submitBox">
				<input type="text" name="groupName" class="input" placeholder="그룹명을 입력 (예: 일반)" value="<?php echo ($modifyNo)?$modify['name']:''; ?>" style="width: 150px" /> 
				<input type="text" name="master" class="input" title="그룹 전체 관리자 ID를 입력하세요" value="<?php echo ($modifyNo)?$modify['master']:''; ?>" style="width: 350px" placeholder="(옵션) 그룹 관리자 아이디 지정 (예: sirini|smile)" />
				<input type="submit" value="<?php echo ($modifyNo)?'수정':'추가'; ?>" />		
			</div>
		</div>
		</form><!--# 그룹 추가/변경 -->

		</div><!--# 우측 몸통 부분 -->

		<div class="clear"></div>

		</div><!--# 폭 설정 -->

	</div><!--# 가운데 정렬 -->

<script src="js/jquery.js"></script>
<script src="admin/admin_group.js"></script>

</body>
</html>
