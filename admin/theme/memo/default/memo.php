<?php
/***************
 * 기본 쪽지함 테마
 ***************
- 이 파일은 grboard/view_memo.php 위치에서 불려집니다.
- 스타일시트는 이 파일과 동일한 위치의 style.css 파일 내용이 반영됩니다.
 */
if(!defined('__GRBOARD__')) exit();

$viewList = 10; # 한 화면에 (기본) 10 개씩 보기
?>

<body>
<div id="installBox">

	<div style="padding: 5px">

		<div class="bigTitle">Read memo</div>

		<div style="padding: 5px; text-align: right">
			<a href="#" onclick="adjustMemo();" style="color: red" title="선택하신 쪽지들을 모두 삭제합니다.">[선택한 쪽지삭제]</a>
			<a href="view_memo.php?action=1"<?php echo ($action==1)?' style="font-weight: bold"':''; ?>>[받은 쪽지]</a> 
			<a href="view_memo.php?action=2"<?php echo ($action==2)?' style="font-weight: bold"':''; ?>>[보낸 쪽지]</a> 
			<a href="view_memo.php?action=3"<?php echo ($action==3)?' style="font-weight: bold"':''; ?>>[안 읽은 쪽지]</a>
		</div>

		<!-- 쪽지 보내기 박스 -->
			<?php
			// 선택한 게시물이 있을 경우 내용보기
			if($action && $viewNo) 
			{
				$getMemo = @mysql_query('select * from '.$dbFIX.'memo_save where (member_key = '.$sessionNo.' or sender_key = '.$sessionNo.') and no = '.$viewNo) or 
					$GR->error('선택한 쪽지 내용을 가져오지 못했습니다.', 0, 'view_memo.php');
				$view = @mysql_fetch_array($getMemo);
				$senderKey = $view['sender_key'];
				$sender = @mysql_fetch_array(mysql_query("select realname, nickname from {$dbFIX}member_list where no = '$senderKey'"));
				if($action != 2 && !$view['is_view']) @mysql_query("update {$dbFIX}memo_save set is_view = '1' where no = '$viewNo'");
			?>
				<div class="titleBar">
					<div class="divTitle"><?php echo stripslashes($view['subject']); ?></div>
				</div>
				
				<div class="tableLeft">보낸사람</div>
				<div class="tableRight"><?php echo ($sender['realname'])?$sender['nickname'].' ('.$sender['realname'].')':'(탈퇴한 회원)'; ?></div>
				<div style="clear:both;"></div>

				<div class="tableLeft">내용</div>
				<div class="tableRight">
					<p style="text-align:left;line-height:160%"><?php echo stripslashes(nl2br($view['content'])); ?></p>
				</div>
				<div style="clear:both;"></div>
				
				<div style="text-align:right;">
				<a href="view_memo.php?action=<?php echo $action; ?>" title="쪽지함 목록보기로 돌아갑니다">[목록보기]</a> 
				<a href="send_memo.php?target=<?php echo $view['sender_key']; ?>" title="답장을 씁니다">[답장쓰기]</a>
				</div>
			<?php
			}
			// 본인이 보낸 쪽지 목록들 보기
			elseif($action == 2) { ?>
			
				<table rules="none" summary="GR Board View Memo" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
				<caption></caption>
				<colgroup>
				<col style="width:80px" />
				<col style="width: 80px" />
				<col />
				<col style="width:50px" />
				<col style="width:60px" />
				</colgroup>
				<thead>
				<tr>
					<th class="titleBar">날짜</th>
					<th class="titleBar">받은이</th>
					<th class="titleBar">제목</th>
					<th class="titleBar">삭제</th>
					<th class="titleBar">보기</th>
				</tr>
				</thead>
				<tbody>
				<?php
				// 본인이 보낸 쪽지내용들 가져오기
				$getMemoList = @mysql_query("select no, member_key, subject, signdate, is_view from {$dbFIX}memo_save where ".
					"sender_key = '$sessionNo' order by no desc limit {$fromRecord}, {$viewList}");
				while($memo = mysql_fetch_array($getMemoList)) {
					$receiver = @mysql_fetch_array(mysql_query("select nickname from {$dbFIX}member_list where no = '".$memo['member_key']."'"));
				?>
				<tr>
					<td style="font-size:8pt;"><?php echo date("Y.m.d", $memo['signdate']); ?></td>
					<td><?php echo $receiver['nickname']; ?></td>
					<td style="padding:5px;text-align:left;">
						<a href="view_memo.php?viewMemoNo=<?php echo $memo['no']; ?>&action=<?php echo $action; ?>" title="이 쪽지 내용을 봅니다" class="normal">
						<?php echo stripslashes($memo['subject']); ?></a>
					</td>
					<td><a href="#" onclick="deleteMemo(<?php echo $memo['no']; ?>);" title="이 쪽지를 삭제합니다">삭제</a></td>
					<td><?php echo ($memo['is_view'])?'봤음':'<span style="color: blue">안봤음</span>'; ?></td>
				</tr>
				<?php
				} # while

				// 페이징 처리
				$totalResult=@mysql_fetch_array(mysql_query('select count(*) as no from '.$dbFIX.'memo_save where sender_key = '.$sessionNo));
				$totalCount=$totalResult['no'];

				$totalPage = ceil($totalCount / 10);
				if($totalCount > 10)
				{
					$printPage = $GR->getPaging(10, $page, $totalPage, 'view_memo.php?action='.$action.'&amp;page=');
				?>
				<tr>
					<td colspan="5" class="paging"><?php echo $printPage; ?></td>
				</tr>
				<?php } # 페이징 ?>
				</tbody>				
				</table>

			<?php
			// 안 읽은 쪽지 보기
			} elseif($action == 3) { ?>

				<table rules="none" summary="GR Board View Memo" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
				<caption></caption>
				<colgroup>
				<col style="width:80px" />
				<col style="width: 80px" />
				<col />
				<col style="width:50px" />
				<col style="width:60px" />
				</colgroup>
				<thead>
				<tr>
					<th class="titleBar">날짜</th>
					<th class="titleBar">보낸이</th>
					<th class="titleBar">제목</th>
					<th class="titleBar">삭제</th>
					<th class="titleBar">보기</th>
				</tr>
				</thead>
				<tbody>
				<?php
				// 쪽지내용들 가져오기
				$getMemoList = @mysql_query("select no, sender_key, subject, signdate, is_view from {$dbFIX}memo_save where ".
					"member_key = '$sessionNo' and is_view = 0 order by no desc limit {$fromRecord}, {$viewList}");
				while($memo = mysql_fetch_array($getMemoList)) {
					$getSender = @mysql_fetch_array(mysql_query("select nickname from {$dbFIX}member_list where no = '".$memo['sender_key']."'"));
				?>
				<tr>
					<td style="font-size:8pt;"><?php echo date("Y.m.d", $memo['signdate']); ?></td>
					<td><?php echo $getSender['nickname']; ?></td>
					<td style="padding:5px;text-align:left;">
						<a href="view_memo.php?viewMemoNo=<?php echo $memo['no']; ?>&action=<?php echo $action; ?>" title="이 쪽지 내용을 봅니다" class="normal">
						<?php echo stripslashes($memo['subject']); ?></a>
					</td>
					<td><a href="#" onclick="deleteMemo(<?php echo $memo['no']; ?>);" title="이 쪽지를 삭제합니다">삭제</a></td>
					<td><?php echo ($memo['is_view'])?'봤음':'<span style="color: blue">안봤음</span>'; ?></td>
				</tr>
				<?php
				} # while

				// 페이징 처리
				$totalResult=@mysql_fetch_array(mysql_query('select count(*) as no from '.$dbFIX.'memo_save where member_key = '.$sessionNo.' and is_view = 0'));
				$totalCount=$totalResult['no'];
				$totalPage = ceil($totalCount / 10);
				if($totalCount > 10)
				{
					$printPage = $GR->getPaging(10, $page, $totalPage, 'view_memo.php?page=');
				?>
				<tr>
					<td colspan="5" class="paging"><?php echo $printPage; ?></td>
				</tr>
				<?php } # 페이징 ?>
				</tbody>				
				</table>

			<?php
			// 선택한 게시물이 없을 경우 목록보기
			} else { ?>
			<form id="list" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<table rules="none" summary="GR Board View Memo" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
				<caption></caption>
				<colgroup>
				<col style="width: 45px" />
				<col style="width:80px" />
				<col style="width: 80px" />
				<col />
				<col style="width:50px" />
				<col style="width:60px" />
				</colgroup>
				<thead>
				<tr>
					<th class="titleBar"><a href="#" onclick="selectAll();">선택</a></th>
					<th class="titleBar">날짜</th>
					<th class="titleBar">보낸이</th>
					<th class="titleBar">제목</th>
					<th class="titleBar">삭제</th>
					<th class="titleBar">보기</th>
				</tr>
				</thead>
				<tbody>
				<?php
				// 쪽지내용들 가져오기
				$getMemoList = @mysql_query("select no, sender_key, subject, signdate, is_view from {$dbFIX}memo_save where ".
					"member_key = '$sessionNo' order by no desc limit {$fromRecord}, {$viewList}");
				while($memo = mysql_fetch_array($getMemoList)) {
					$getSender = @mysql_fetch_array(mysql_query("select nickname from {$dbFIX}member_list where no = '".$memo['sender_key']."'"));
				?>
				<tr>
					<td><input type="checkbox" name="delTargets[]" value="<?php echo $memo['no']; ?>" /></td>
					<td style="font-size: 8pt"><?php echo date("Y.m.d", $memo['signdate']); ?></td>
					<td><?php echo $getSender['nickname']; ?></td>
					<td style="padding:5px; text-align:left">
						<a href="view_memo.php?viewMemoNo=<?php echo $memo['no']; ?>&action=<?php echo $action; ?>" title="이 쪽지 내용을 봅니다" class="normal">
						<?php echo stripslashes($memo['subject']); ?></a>
					</td>
					<td><a href="#" onclick="deleteMemo(<?php echo $memo['no']; ?>);" title="이 쪽지를 삭제합니다">삭제</a></td>
					<td>
						<?php echo ($memo['is_view'])?'봤음':'<span style="color: blue">안봤음</span>'; ?>
					</td>
				</tr>
				<?php
				} # while

				// 페이징 처리
				$totalResult=@mysql_fetch_array(mysql_query('select count(*) as no from '.$dbFIX.'memo_save where member_key = '.$sessionNo));
				$totalCount=$totalResult['no'];

				$totalPage = ceil($totalCount / 10);
				if($totalCount > 10)
				{
					$printPage = $GR->getPaging(10, $page, $totalPage, 'view_memo.php?page=');
				?>
				<tr>
					<td colspan="6" class="paging"><?php echo $printPage; ?></td>
				</tr>
				<?php } # 페이징 ?>
				</tbody>				
				</table>
			</form>
			<?php } # 목록보기 ?>

		<div style="height:10px;"></div>

	</div>
</div>