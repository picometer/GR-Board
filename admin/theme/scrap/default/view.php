<?php
/***************
 * 기본 스크랩 테마
 ***************
- 이 파일은 grboard/view_scrap.php 위치에서 불려집니다.
- 스타일시트는 이 파일과 동일한 위치의 style.css 파일 내용이 반영됩니다.
 */
if(!defined('__GRBOARD__')) exit();
?>

<body>
<div id="scrapBox">

	<div style="padding: 5px">

		<div class="bigTitle">Scrap book</div>

		<!-- 박스 -->
			<?php
			// 선택한 스크랩이 있을 경우 내용보기
			if($viewNo) 
			{
				$getMemo = @mysql_query('select * from '.$dbFIX.'scrap_book where member_key = '.$_SESSION['no'].' and no = '.$viewNo) or 
					$GR->error('선택한 스크랩 내용을 가져오지 못했습니다.', 0, 'view_scrap.php');
				$view = @mysql_fetch_array($getMemo);
				$getPost = @mysql_fetch_array(mysql_query('select name, subject, content from '.$dbFIX.'bbs_'.$viewID.' where no = '.$view['article_num']));
			?>
				<div class="titleBar">
					<div class="divTitle"><?php echo stripslashes($getPost['subject']); ?></div>
				</div>

				<div class="tableLeft">설명</div>
				<div class="tableRight"><div><?php echo stripslashes(nl2br($view['comment'])); ?></div></div>
				<div style="clear: both"></div>
				
				<div class="tableLeft">작성자</div>
				<div class="tableRight"><div><?php echo $getPost['name']; ?></div></div>
				<div style="clear: both"></div>

				<div class="tableLeft">내용</div>
				<div class="tableRight"><div><?php echo stripslashes(nl2br($getPost['content'])); ?></div></div>
				<div style="clear: both"></div>
				
				<div style="text-align: right">
				<a href="view_scrap.php" title="스크랩 목록보기로 돌아갑니다">[목록보기]</a> 
				<a href="board.php?id=<?php echo $viewID; ?>&amp;articleNo=<?php echo $view['article_num']; ?>" onclick="window.open(this.href, '_blank'); return false;" title="새 창으로 게시물을 열어 봅니다.">[보러가기]</a>
				</div>

			<?php
			// 만약 스크랩 추가하기일 시
			} elseif($_GET['isAdd']) { 
				$getPost = @mysql_fetch_array(mysql_query('select subject, content from '.$dbFIX.'bbs_'.$_GET['id'].' where no = '.$_GET['article_num']));
				$isExist = @mysql_fetch_array(mysql_query('select no from '.$dbFIX.'scrap_book where member_key = '.$_SESSION['no'].' and id = \''.$_GET['id'].'\' and article_num = '.$_GET['article_num']));
				if($isExist['no']) $GR->error('이미 스크랩 하셨습니다.', 0, 'view_scrap.php');
			?>
			<form id="addScrap" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<div><input type="hidden" name="addScrap" value="1" />
			<input type="hidden" name="article_num" value="<?php echo $_GET['article_num']; ?>" />
			<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" /></div>
				<div class="titleBar">
					<div class="divTitle">내 스크랩북에 추가하기</div>
				</div>
				<div class="tableLeft" title="이 게시물을 스크랩한 목적/이유를 작성합니다. 후에 찾기 쉽도록 해주면 좋습니다.">설명넣기</div>
				<div class="tableRight">
					<textarea name="comment" cols="45" rows="3" class="textarea"><?php echo stripslashes(nl2br($view['comment'])); ?></textarea>
				</div>
				<div style="clear: both"></div>

				<div class="tableLeft">제목</div>
				<div class="tableRight"><?php echo stripslashes($getPost['subject']); ?></div>
				<div style="clear: both"></div>

				<div class="tableLeft">내용</div>
				<div class="tableRight"><?php echo stripslashes(nl2br($getPost['content'])); ?></div>
				<div style="clear: both"></div>

				<div style="text-align: center; padding-top: 20px"><input type="image" src="image/admin/btn_add.gif" alt="추가하기" /></div>

			</form>

			<?php
			// 선택한 게시물이 없을 경우 목록보기
			} else { ?>
				<table rules="none" summary="GR Board View Scrap" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
				<caption></caption>
				<colgroup>
				<col style="width: 80px" />
				<col />
				<col style="width:50px" />
				</colgroup>
				<thead>
				<tr>
					<th class="titleBar">작성자</th>
					<th class="titleBar">제목</th>
					<th class="titleBar">삭제</th>
				</tr>
				</thead>
				<tbody>
				<?php
				// 스크랩한 것들 가져오기
				$getScrap = @mysql_query('select * from '.$dbFIX.'scrap_book where member_key = '.$_SESSION['no'].' order by no desc limit '.$fromRecord.', 10');
				while($memo = mysql_fetch_array($getScrap)) {
					$post = @mysql_fetch_array(mysql_query('select name, subject from '.$dbFIX.'bbs_'.$memo['id'].' where no = '.$memo['article_num']));
				?>
				<tr class="hover">
					<td><?php echo $post['name']; ?></td>
					<td style="padding:5px;text-align:left;">
						<a href="view_scrap.php?viewNo=<?php echo $memo['no']; ?>&viewID=<?php echo $memo['id']; ?>" title="<?php echo htmlspecialchars(stripslashes($memo['comment'])); ?>" class="normal">
						<?php echo stripslashes($post['subject']); ?></a>
					</td>
					<td><a href="#" onclick="deleteScrap(<?php echo $memo['no']; ?>);" title="이 스크랩을 삭제합니다"><img src="image/admin/admin_delete.gif" alt="삭제" /></a></td>
				</tr>
				<?php
				} # while

				// 페이징 처리
				$totalResult=@mysql_fetch_array(mysql_query('select count(*) as no from '.$dbFIX.'scrap_book where member_key = '.$_SESSION['no']));
				$totalCount=$totalResult['no'];
				$totalPage = ceil($totalCount / 10);
				if($totalCount > 10)
				{
					$printPage = $GR->getPaging(10, $page, $totalPage, 'view_scrap.php?page=');
				?>
				<tr>
					<td colspan="5" class="paging"><?php echo $printPage; ?></td>
				</tr>
				<?php } # 페이징 ?>
				</tbody>				
				</table>
			
			<?php } # 목록보기 ?>

		<div style="height: 10px"></div>
	</div>
</div>