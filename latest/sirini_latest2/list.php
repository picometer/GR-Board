<div class="latestTitle"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>"><?php echo $latestTitle; ?></a></div>
<?php
// 게시물 루프
while($latest = mysql_fetch_array($getData))
{
	$title = cutString(stripslashes($latest['subject']), $cutSize);
	?>
<div class="latestSubject">
<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $latest['no']; ?>"><?php echo $title; ?></a>	
<?php if($latest['comment_count']) { ?><span class="latestCommentNum">(<?php echo $latest['comment_count']; ?>)</span><?php } ?>
</div>
<?php if($getContent) { ?>
<div class="latestContent"><?php echo cutString(stripslashes(strip_tags($latest['content'])), $cutContentSize); ?></div>
<?php } ?>
	<?php
} # while
?>