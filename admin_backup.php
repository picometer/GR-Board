<?php
// 기본 클래스 + DB 클래스 @sirini
include 'class/common.php';
include 'class/database.php';
$GR = new COMMON;
$GR->dbConn();
$DB = new DATABASE;
$dbName = $GR->dbName;

// 관리자인지 확인한다. @sirini
if($_SESSION['no'] != 1) $GR->error('관리자 화면은 관리자만 접근할 수 있습니다.', 1, 'CLOSE');

if($_GET['db_save_ok']) {
	@set_time_limit(0);
	$saveDay = date('Ymd', time());
	$DB->dbHeader('grboard_'.$saveDay.'.sql');
	$DB->allDown($dbName);
	exit();
}

// 문서설정 @sirini
$title = 'GR Board Admin Page ( DB Backup )';
include 'html_head.php';
include 'admin/admin_left_menu.php';
?>
		<!-- 현재 페이지 도움말 -->
		<div id="grboardHelpBox">
			GR Board 가 사용중인 테이블들의 목록과 통계를 볼 수 있는 페이지 입니다. <a href="#" title="도움말을 더 봅니다" id="helpBackupBtn">...도움말보기 <img src="image/admin/btn_help_more.gif" alt="더 보기" /></a>
			<div id="helpBox" style="display: none">
			아래의 표는 GR Board 가 현재 사용중인 테이블들의 목록입니다.<br />
			GR Board 는 게시판일 경우 `<strong>gr_bbs_</strong>` 로 시작하고 코멘트(댓글)일 경우 `<strong>gr_comment_</strong>` 로 시작하며,<br />
			그 밖에 `<strong>gr_</strong>` 로 시작하는 테이블들은 모두 특정 작업을 위한 설정 저장 테이블들 입니다.<br />
			<br />
			GR Board 는 현재 DBMS로 MySQL 을 사용하고 있습니다. (DBMS: 데이터베이스 관리 시스템)<br />
			게시판 프로그램의 이전과 복구, 제거 등의 과정에서는 항상 <strong>DB백업이 선행</strong>되어야 합니다.<br />
			이미 이 페이지를 보시기 전에 안내 대화상자를 보셨겠지만 GR Board 가 자체적으로 제공하는 백업기능보다는<br />
			<strong>phpMyAdmin</strong> 이라는 MySQL DB관리 프로그램을 사용하시는 것이 더 안전함을 알려드립니다.<br />
			(대부분의 웹호스팅/서버에서 이 프로그램을 지원해주고 있습니다.)<br />
			<br />
			특정 테이블(게시판)이 지나치게 많은 DB사용량을 보여줄 경우(가령 `gr_bbs_pds`) 해당 게시판의 쓰기 기능을 막고<br />
			새로운 게시판을 추가하여 지나치게 특정 게시판에 부하가 걸리지 않도록 조절해 보시는 것도 유용할 것입니다.
			</div>
		</div><!--# 현재 페이지 도움말 -->

		<!-- 현재 DB 상황 -->
		<div class="mvBack" id="admDBStat">
			<div class="mv">DB 사용상태</div>
			<table rules="none" summary="GR Board DB Status" cellpadding="0" cellspacing="0" border="0" style="width:100%;">
			<caption></caption>
			<thead>
			<tr>
				<th class="titleBar">번호</th>
				<th class="titleBar">테이블 이름</th>
				<th class="titleBar">줄</td>
				<th class="titleBar">Data용량</th>
				<th class="titleBar">Index용량</th>
				<th class="titleBar">전체용량</th>
				<th class="titleBar">생성시간</th>
			</tr>
			</thead>
			<tbody>
			<?php
			// 조회해서 결과셋을 뿌려준다
			$resultQue = $GR->query("show table status from {$dbName} like '{$dbFIX}%'");

			// 결과셋을 뿌려준다.
			$dbSize = 0;
			$number = 1;
			while($tableData = $GR->fetch($resultQue)) {
				// 전체 DB 사이즈를 저장한다.
				$dbSize += $tableData['Data_length'] + $tableData['Index_length'];
				?>
			<tr class="hover">
				<td class="boardList"><?php echo $number; ?></td>
				<td class="boardList"><?php echo $tableData['Name']; ?></td>
				<td class="boardList"><?php echo $tableData['Rows']; ?></td>
				<td class="boardList"><?php echo floor($tableData['Data_length'] / 1024)."KB"; ?></td>
				<td class="boardList"><?php echo floor($tableData['Index_length'] / 1024)."KB"; ?></td>
				<td class="boardList"><?php echo floor(($tableData['Data_length']+$tableData['Index_length']) / 1024).'KB'; ?></td>
				<td class="boardList"><?php echo $tableData['Create_time']; ?></td>
			</tr>
				<?php
					$number++;
			} # while
			?>	
			<tr>
				<td colspan="7" class="paging">총 DB 크기 : <?php echo number_format(floor($dbSize / 1024)); ?> KB</td>
			</tr>
			</tbody>
			</table>

		</div>

		</div>

		<div class="clear"></div>

	</div>

</div>

<script src="js/jquery.js"></script>
<script src="admin/admin_backup.js"></script>

</body>
</html>