<div class="grLatestBox">
<div class="latestTitle"><?php echo $latestTitle; ?></div>
<?php
// 게시물 루프
while($latest = mysql_fetch_array($getData))
{
	$title = cutString(stripslashes($latest['subject']), $cutSize);
	?>
<div class="latestSubject"><img src="<?php echo $path; ?>/arrow.gif" alt="" style="vertical-align: middle" />
<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $latest['no']; ?>"><?php echo $title; ?></a>	
<?php if($latest['comment_count']) { ?><span class="latestCommentNum">(<?php echo $latest['comment_count']; ?>)</span><?php } ?>
<span class="latestCommentNum">(<?php echo date($dateFormat, $latest['signdate']); ?>)</span>
</div>
	<?php
} # while
?>
</div>