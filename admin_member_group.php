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
	$GR->query("update {$dbFIX}member_group set name = '".$_POST['groupName']."' where no = $modifyNo");
	$GR->error('그룹 이름을 변경하였습니다.', 0, 'admin_member_group.php');

// 그룹 추가 처리 @sirini
} elseif($mode == 'add') {
	$GR->query("insert into {$dbFIX}member_group set no = '', name = '".$_POST['groupName']."', make_time = '".time()."'");
	$GR->error($_POST['groupName'] . ' 그룹을 추가하였습니다.', 0, 'admin_member_group.php');
}

// 그룹 삭제 처리 @sirini
if($deleteNo) {
	$GR->query("delete from {$dbFIX}member_group where no = '$deleteNo'");
	$GR->query("update {$dbFIX}member_list set group_no = '1' where group_no = '$deleteNo'");
	$GR->error('삭제했습니다. 해당 그룹에 속했던 멤버들은 모두 기본 그룹 소속이 됩니다.', 0, 'admin_member_group.php');
}

// 그룹 정보 변경시 기존 정보 가져오기 @sirini
if($modifyNo) $modify = $GR->getArray('select * from '.$dbFIX.'member_group where no = '.$modifyNo);

// 문서설정
$title = 'GR Board Admin Page ( Member Group )';
include 'html_head.php';
include 'admin/admin_left_menu.php';
?>
		<!-- 현재 페이지 도움말 -->
		<div id="grboardHelpBox">
			GR Board 에 등록된 멤버(회원)들의 그룹들을 관리하는 곳입니다. <a href="#" title="도움말을 더 봅니다" id="helpGroupBtn">...도움말보기 <img src="image/admin/btn_help_more.gif" alt="더 보기" /></a>
			<div id="helpBox" style="display: none">
			게시판과 마찬가지로 GR보드에 등록되어있는 멤버들의 그룹을 관리하는 곳입니다.<br />
			이곳에서 생성된 멤버 그룹들을 이용해서 멤버 관리를 통해 멤버들의 그룹을 지정하고,<br />
			지정된 그룹에 속한 멤버들을 대상으로 작업들을 할 수 있습니다.<br />
			</div>
		</div><!--# 현재 페이지 도움말 -->

		<!-- 그룹 목록 -->
		<div class="mvBack" id="admGroupList">
			<div class="mv">멤버 그룹 목록</div>

			<table rules="none" summary="GR Board Member Group List" cellpadding="0" cellspacing="0" border="0" style="width: 100%">
			<caption></caption>
			<colgroup>
			<col style="width: 40px" />
			<col />
			<col style="width: 80px" />
			<col style="width: 80px" />
			<col style="width: 70px" />
			<col style="width: 70px" />
			</colgroup>
			<thead>
			<tr>
				<th class="titleBar">번호</th>
				<th class="titleBar">그룹명</th>
				<th class="titleBar">멤버수</th>
				<th class="titleBar">생성일</th>
				<th class="titleBar">변경</th>
				<th class="titleBar">삭제</th>
			</tr>
			</thead>
			<tbody>
			<?php
			// 목록화
			$getGroup = $GR->query('select * from '.$dbFIX.'member_group');
			while($data = $GR->fetch($getGroup))
			{
				?>
			<tr>
				<td class="boardList"><?php echo $data['no']; ?></td>
				<td><?php echo $data['name']; ?></a></td>
				<td class="boardList">
				<?php
				// 이 그룹에 속한 멤버수
				$getCntBoard = $GR->getArray('select count(*) from '.$dbFIX.'member_list where group_no = '.$data['no']);
				echo $getCntBoard[0];
				?>
				</td>
				<td class="boardList"><?php echo date('Y.m.d', $data['make_time']); ?></td>
				<td class="boardList"><a href="#" onclick="modifyMemberGroup(<?php echo $data['no']; ?>);" title="선택한 그룹을 변경합니다."><img src="image/admin/admin_group_modify.gif" alt="변경하기" /></a></td>
				<td class="boardList"><a href="#" onclick="deleteMemberGroup(<?php echo $data['no']; ?>);" title="선택한 그룹을 삭제합니다."><img src="image/admin/admin_group_delete.gif" alt="삭제하기" /></a></td>
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
				<input type="text" name="groupName" class="input" title="그룹명을 입력하세요 (예: 친구)" value="<?php echo ($modifyNo)?$modify['name']:''; ?>" placeholder="추가할 그룹명을 입력 (예: 일반)" style="width: 300px" />
				<input type="submit" value="<?php echo ($modifyNo)?'변경':'추가'; ?>" />		
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
