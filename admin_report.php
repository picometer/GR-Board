<?php 
// 기본 클래스
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 관리자인지 확인한다.
if($_SESSION['no'] != 1) $GR->error('관리자 화면은 관리자만 접근할 수 있습니다.', 1, 'CLOSE');

// 그룹 정보 변경시 기존 정보 가져오기
if($modifyNo) $modify = $GR->getArray('select * from '.$dbFIX.'group_list where no = '.$modifyNo);

// 문서설정
$title = 'GR Board Admin Page ( Report )';
include 'html_head.php';
include 'admin/admin_left_menu.php';
?>

		<!-- 현재 페이지 도움말 -->
		<div id="grboardHelpBox">
			신고된 게시물들을 한 눈에 확인할 수 있는 곳입니다. <a href="#" title="도움말을 더 봅니다" id="helpReportBtn">...도움말보기 <img src="image/admin/btn_help_more.gif" alt="더 보기" /></a>
			<div id="helpBox" style="display: none">
			웹사이트를 운영하다보면 해당 웹사이트의 운영규칙에 위배되는 게시물들도 작성되게 됩니다.<br />
			관리자분들이 일일이 그런 게시물들을 24시간 확인할 수 없기 때문에, GR Board 에서는<br />
			"<strong>신고 기능</strong>" 을 추가하여 일반 방문객 분들도 광고글/성인글 등을 관리자에게 알릴 수 있도록<br />
			지원하고 있습니다.<br />
			<br />
			신고된 게시물들은 해당 게시판의 마스터들에게도 쪽지를 통해 알려지게 되며,<br />
			이미 삭제되었거나 이동 되는 등의 조치가 이루어졌을 수도 있습니다.<br />
			신고는 중복해서 할 수 없으며, 이미 처리된 신고 내용이라 하더라도 이 곳에서<br />
			모두 조회됩니다.<br />
			</div>
		</div><!--# 현재 페이지 도움말 -->

		<!-- 게시판 목록 -->
		<div class="mvBack" id="admBoardList">
			<div class="mv">신고 접수 목록</div>

			<form id="searchBoard" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<?php
			if(!$page) $page = 1;
			$viewRows = 25;
			$fromRecord = ($page - 1) * $viewRows;
			$que = 'select * from '.$dbFIX.'report order by no desc limit '.$fromRecord.', '.$viewRows;
			$forPageQue = 'select no from '.$dbFIX.'report';
			
			// 쿼리실행
			$resultQue = $GR->query($que);

			// 페이징 처리
			$totalResult = $GR->getArray('select count(*) as no from '.$dbFIX.'report');
			$totalCount = $totalResult['no'];
			?>
			<table rules="none" summary="GR Board Report Status" cellpadding="0" cellspacing="0" border="0" style="width: 100%">
			<caption></caption>
			<colgroup>
			<col style="width: 40px" />
			<col style="width: 100px" />
			<col />
			<col style="width: 100px" />
			<col style="width: 60px" />
			</colgroup>
			<thead>
			<tr>
				<th class="titleBar">번호</th>
				<th class="titleBar">게시판 ID</th>
				<th class="titleBar">신고내용</th>
				<th class="titleBar">조치</th>
				<th class="titleBar">상태</th>
			</tr>
			</thead>
			<tbody>
			<?php
			// 가상번호
			$totalBoard = ceil($totalCount - (($page -1) * $viewRows));

			// 목록화
			while($data = $GR->fetch($resultQue)) { ?>
			<tr>
				<td class="boardList"><?php echo $totalBoard; ?></td>
				<td class="boardList"><a href="board.php?id=<?php echo $data['id']; ?>" title="클릭하시면 현재창으로 지정된 게시판으로 이동합니다."><?php echo $data['id']; ?></a></td>
				<td><?php echo $data['reason']; ?></td>
				<td class="boardList">
				<a href="board.php?id=<?php echo $data['id']; ?>&amp;articleNo=<?php echo $data['article_num']; ?>" onclick="window.open(this.href, '_blank'); return false" title="새 창으로 게시물 보기"><img src="image/icon/article_trace_icon.gif" alt="보기" /></a> &nbsp;
				<a href="write.php?id=<?php echo $data['id']; ?>&amp;mode=modify&amp;articleNo=<?php echo $data['article_num']; ?>&amp;isReported=<?php echo $data['no']; ?>" onclick="window.open(this.href, '_blank'); return false" title="새 창으로 수정화면 열기"><img src="image/admin/admin_code_create.gif" alt="수정" /></a> &nbsp;
				<a href="#" onclick="deletePost('<?php echo $data['id']; ?>', '<?php echo $data['article_num']; ?>', '<?php echo $data['no']; ?>');" title="이 게시물을 삭제하기"><img src="image/admin/admin_delete.gif" alt="삭제" /></a>
				</td>
				<td style="text-align: center"><?php 
					if($data['status'] == 1) echo '<span style="color: green">수정됨</span>';
					elseif($data['status'] == 2) echo '<span style="color: red">삭제됨</span>';
					else echo '대기중';
				?></td>
			</tr>
				<?php
					$totalBoard--;
			} # while

			// 페이징
			$totalPage = ceil($totalCount / $viewRows);
			$printPage = $GR->getPaging($viewRows, $page, $totalPage, $grboard.'/admin_report.php?page=');
			if($printPage) { ?>
			<tr>
				<td colspan="8" class="paging">
				<?php echo $printPage; ?>
				</td>
			</tr>
			<?php } ?>
			</tbody>
			</table>			
			</form>
		</div><!--# 신고 목록 -->
	
		<!-- 위아래 공백 -->
		<div class="vSpace"></div>

		</div><!--# 우측 몸통 부분 -->

		<div class="clear"></div>

		</div><!--# 폭 설정 -->	

</div><!--# 가운데 정렬 -->

<script src="<?php echo $grboard; ?>/js/jquery.js"></script>
<script src="<?php echo $grboard; ?>/admin/admin_board.js"></script>
<script src="<?php echo $grboard; ?>/admin/admin_report.js"></script>

</body>
</html>