<?php
/****************
 * 기본 신고하기 테마
 ****************
- 이 파일은 grboard/report.php 위치에서 불려집니다.
- 스타일시트는 이 파일과 동일한 위치의 style.css 파일 내용이 반영됩니다.
 */
if(!defined('__GRBOARD__')) exit();
?>

<body>
<div id="scrapBox">

	<div style="padding: 5px">

		<div class="bigTitle">Report</div>

		<!-- 박스 -->
			<?php
			$getPost = @mysql_fetch_array(mysql_query('select subject, content from '.$dbFIX.'bbs_'.$_GET['id'].' where no = '.$_GET['article_num']));
			?>
			<form id="addReport" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<div><input type="hidden" name="addReport" value="1" />
			<input type="hidden" name="article_num" value="<?php echo $_GET['article_num']; ?>" />
			<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" /></div>
				<div class="titleBar">
					<div class="divTitle">게시물 신고하기</div>
				</div>
				<div class="tableLeft" title="이 게시물을 신고한 이유를 작성해 주세요.">신고사유</div>
				<div class="tableRight">
					<textarea name="reason" cols="45" rows="3" class="textarea"></textarea>
				</div>
				<div style="clear: both"></div>

				<div class="tableLeft">게시물 제목</div>
				<div class="tableRight"><?php echo stripslashes($getPost['subject']); ?></div>
				<div style="clear: both"></div>

				<div class="tableLeft">게시물 내용</div>
				<div class="tableRight"><?php echo stripslashes(nl2br($getPost['content'])); ?></div>
				<div style="clear: both"></div>

				<div style="text-align: center; padding-top: 20px"><input type="image" src="image/admin/btn_ok.gif" alt="신고하기" /></div>

			</form>

		<div style="height: 10px"></div>
	</div>
</div>