<?php
// 게시물 루프
while($latest = mysql_fetch_array($getData))
{
	$title = cutString(stripslashes($latest['subject']), $cutSize);
	?>
<div class="latestSubject"><img src="<?php echo $path; ?>/arrow.gif" alt="" style="vertical-align: middle" />
<span class="latestName"><?php echo $latest['name']; ?> |</span>&nbsp;
<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $latest['no']; ?>"><?php echo $title; ?></a>	
<?php if($latest['comment_count']) { ?><span class="latestCommentNum">+<?php echo $latest['comment_count']; ?></span><?php } ?>
</div>
	<?php
} # while
?>