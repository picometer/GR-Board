<?php
// 게시물 루프
while($latest = mysql_fetch_array($getData))
{
	?>
<div class="latestNoticeTitle">
	<span class="latestNoticeDate">(<?php echo date($dateFormat, $latest['signdate']); ?>)</span>
	<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>"><?php echo stripslashes($latest['subject']); ?> 
	<?php if($latest['comment_count']) { ?><span class="latestNoticeCommentNum">(<?php echo $latest['comment_count']; ?>)</span><?php } ?></a>
</div>
<?php if($getContent) { ?>
<div class="latestNoticeContent">
	<?php echo cutString(stripslashes(nl2br($latest['content'])), $cutContentSize); ?>
</div>
<?php } ?>
	<?php
} # while
?>