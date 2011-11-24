<?php 
include 'admin/admin_board_head.php'; 
include 'admin/admin_left_menu.php';
?>

		<!-- 현재 페이지 도움말 -->
		<div id="grboardHelpBox">
			GR Board 의 게시판들을 관리하는 화면 입니다. <a href="#" title="도움말을 더 봅니다" id="helpBoardBtn">...도움말보기 <img src="image/admin/btn_help_more.gif" alt="더 보기" /></a>
			<div id="helpBox" style="display: none">
			GR Board 에서는 게시판을 생성할 때 가로 650px 크기로 해서 기본적으로 생성이 됩니다.<br />
			"<strong>상단 내용</strong>" 을 주목해 주십시오. 네모난 박스 안에 게시판 상단부분에 들어갈 내용들이 적혀져 있습니다.<br />
			해당부분을 원하시는대로 수정하시게 되면 게시판을 미리보기 했을 때 보여지는 페이지가 달라지게 됩니다.<br />
			<br />
			일반적으로 타 게시판에서 지원하듯 <strong>헤드/풋 (노프레임)</strong>을 지원 합니다.<br />
			헤드/풋 이란 게시판 상단과 하단에 들어갈 내용을 파일로 만들어서 게시판을 부를 때마다<br />
			게시판의 상단과 하단에 해당 파일들을 불러서 하나의 완성된 페이지를 보여주는 방식을 말합니다.<br />
			"<strong>상단 파일</strong>" 을 주목해 주십시오. 해당 부분에 GR Board 밖에 존재하는 특정 파일 (예: head.php)의<br />
			상대경로를 적어줍니다. (예: ../head.php) 그러면 그 파일이 게시판 상단에서 먼저 불러지고, 그 후 게시판이 불러집니다.<br />
			<br />
			아래의 각 항목별로 마우스를 가져다 대면 자세한 설명을 보실 수 있습니다.<br />
			우선 테마를 변경하고 싶을 땐 "<strong>테마(스킨) 선택</strong>" 의 선택상자를 클릭하여 목록에서 원하는 것을<br />
			선택해 주십시오. 특정 테마(스킨)의 경우에는 일부 데이터를 목록에서 바로 볼 수 있도록 "<strong>방명록 형태</strong>" 를 원할 수 있습니다.<br />
			<br />
			댓글을 받을 때 "<strong>오픈아이디 사용</strong>" 에 체크하면 로그인 없이도 댓글을 쉽게 남길 수 있도록 해줍니다.<br />
			각 게시판별로 "<strong>트랙백 사용</strong>" 에 체크하면 트랙백도 외부에서 받을 수 있습니다.<br />
			1시간 단위로 변경되는 GR Board 의 트랙백 URL 주소가 무작위 스팸을 방지해 줍니다.<br />
			<br />
			각종 접근제한을 레벨별로 걸어둘 수 있도록 "<strong>목록보기 제한</strong>" 등의 항목이 준비되어 있으며,<br />
			각 게시판별로 관리자를 정할 수 있도록 "<strong>관리자 ID</strong>" 항목이 준비되어 있습니다.<br />
			최대 10개까지 첨부파일을 올릴 수 있도록 설정할 수 있습니다. "<strong>파일첨부</strong>" 를 주목해 주십시오.<br />
			<br />
			각 설정항목들을 해당 게시판이 속한 그룹 내 전체 게시판들과 동일하게 설정하고 싶을 경우<br />
			항목별로 우측에 있는 "<strong>모두 변경</strong>" 을 체크하시면 됩니다.
			</div>
		</div><!--# 현재 페이지 도움말 -->

		<!-- 게시판 목록 -->
		<div class="mvBack" id="admBoardList">
			<div class="mv">게시판 목록</div>

			<form id="searchBoard" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<?php
			// 검색할 게시판명이 있다면 
			$que = 'select * from '.$dbFIX.'board_list';
			if($searchBoardList)
			{
				$que .= " where id like '%{$searchBoardList}%' order by no desc limit {$fromRecord}, {$viewRows}";
				$forPageQue = "select no from {$dbFIX}board_list where id like '%{$searchBoardList}%'";
			}
			// 정렬옵션이 있다면
			elseif($_GET['sortList'])
			{
				$que .= " order by id {$sortBy} limit {$fromRecord}, {$viewRows}";
				$forPageQue = 'select no from '.$dbFIX.'board_list';
			}
			// 아무것도 없다면 기본 부름
			else
			{
				$que .= " order by no desc limit {$fromRecord}, {$viewRows}";
				$forPageQue = 'select no from '.$dbFIX.'board_list';
			}
			// 쿼리실행
			$resultQue = $GR->query($que);

			// 페이징 처리를 위해 결과셋별로 총 목록 수 저장
			$totalResult = $GR->getArray('select count(*) as no from '.$dbFIX.'board_list');
			$totalCount = $totalResult['no'];
			?>
			<table rules="none" summary="GR Board Board Status" cellpadding="0" cellspacing="0" border="0" style="width: 100%">
			<caption></caption>
			<colgroup>
			<col style="width: 40px" />
			<col style="width: 60px" />
			<col />			
			<col style="width: 50px" />
			<col style="width: 80px" />
			<col style="width: 100px" />
			<col style="width: 140px" />
			<col style="width: 80px" />
			<col style="width: 40px" />
			</colgroup>
			<thead>
			<tr>
				<th class="titleBar">번호</th>
				<th class="titleBar">ID</th>
				<th class="titleBar">이름</th>
				<th class="titleBar">그룹명</th>
				<th class="titleBar" style="cursor:help;">
					<span class="mouseHelp" title="목록보기 접근가능레벨">E</span>/
					<span class="mouseHelp" title="글보기 접근가능레벨">V</span>/
					<span class="mouseHelp" title="글쓰기 가능레벨">W</span>/
					<span class="mouseHelp" title="코멘트쓰기 가능레벨">C</span>
				</th>
				<th class="titleBar">미리보기</th>
				<th class="titleBar">테마(스킨)</th>
				<th class="titleBar">생성일</th>
				<th class="titleBar">삭제</th>
			</tr>
			</thead>
			<tbody>
			<?php
			// 가상번호
			$totalBoard = ceil($totalCount - (($page - 1) * $viewRows));

			// 목록화
			while($data = $GR->fetch($resultQue)) { ?>
			<tr>
				<td class="boardList"><?php echo $totalBoard; ?></td>
				<td class="boardList"><a href="admin_board.php?boardID=<?php echo $data['id']; ?>&amp;page=<?php echo $page; ?>" title="클릭하시면 게시판 수정 패널이 열립니다"><?php echo $data['id']; ?></a></td>
				<td class="boardList center"><?php echo $data['name']; ?></td>
				<td class="boardList">
				<?php
				// 그룹명 가져오기
				$getGroupName = $GR->getArray('select name from '.$dbFIX.'group_list where no = '.$data['group_no']);
				echo $getGroupName[0];
				?></td>
				<td class="boardList"><?php echo $data['enter_level'].'/'.$data['view_level'].'/'.$data['write_level'].'/'.$data['comment_write_level']; ?></td>
				<td class="boardList"><a href="board.php?id=<?php echo $data['id']; ?>" title="게시판을 미리 봅니다."><img src="image/admin/admin_board_view.gif" alt="미리보기" /></a></td>
				<td class="boardList"><?php echo $data['theme']; ?></td>
				<td class="boardList"><?php echo date("Y.m.d", $data['make_time']); ?></td>
				<td class="boardList"><a href="#" onclick="deleteTable(<?php echo $data['no']; ?>, '<?php echo $data['id']; ?>');" title="이 게시판을 삭제합니다."><img src="image/admin/admin_board_delete.gif" alt="게시판 제거하기" /></a></td>
			</tr>
				<?php
					$totalBoard--;
			} # while

			// 페이징
			$totalPage = ceil($totalCount / $viewRows);
			$printPage = $GR->getPaging($viewRows, $page, $totalPage, 'admin_board.php?page=');
			if($printPage) { ?>
			<tr>
				<td colspan="9" class="paging">
				<?php echo $printPage; ?>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="9" class="submitBox">
				<a href="admin_board.php?sortList=<?php echo $sortBy; ?>" title="게시판 ID 를 알파벳대로 순차/역순 정렬합니다">&middot; 알파벳순 정렬</a>&nbsp;
				&middot; 게시판 검색
				<input type="text" name="searchBoardList" class="input" placeholder="게시판 ID 를 입력 (예: freeboard)" value="<?php if(isset($searchBoardList)) echo $searchBoardList; ?>" style="width: 200px" />
				을 <input type="text" name="viewRows" class="input" size="3" maxlength="3" value="<?php echo $viewRows; ?>" /> 개씩
				<input type="submit" value="검색" title="주어진 조건에 맞게 검색 합니다" />
				</td>
			</tr>
			</tbody>
			</table>			
			</form>
		</div>
	
		<div class="vSpace"></div>

		<?php
		// 선택한 게시판이 있다면 수정, 없다면 추가 @sirini
		$layout = $GR->getArray('select var from '.$dbFIX.'layout_config where opt = \'theme\' limit 1');
		if(isset($boardID)) include 'admin/admin_board_modify.php';
		else include 'admin/admin_board_add.php';
		?>
		</div>

		<div class="clear"></div>

		</div>
</div>

<script src="js/jquery.js"></script>
<script src="admin/admin_board.js"></script>

</body>
</html>