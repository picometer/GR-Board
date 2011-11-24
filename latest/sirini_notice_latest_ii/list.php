<?php
// 게시물 루프
while($latest = mysql_fetch_array($getData))
{
	?>
<div class="latestNoticeTitle">
	<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $latest['no']; ?>" title="클릭하시면 게시물을 보러 갑니다"><?php echo stripslashes($latest['subject']); ?></a>
</div>
<?php if($getContent) { ?>
<div class="latestNoticeContent"><?php echo cutString(stripslashes(nl2br($latest['content'])), $cutContentSize); ?></div>
<?php } ?>
	<?php
} # while
?>