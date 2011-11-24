<div class="latestTitle"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>"><?php echo $latestTitle; ?></a></div>
<?php
// 게시물 루프
while($latest = mysql_fetch_array($getData))
{
	?>
<div class="latestSubject" onmouseover="this.style.backgroundColor='#F7F7F7'" onmouseout="this.style.backgroundColor=''">
<?php if($latest['category']) { ?><span class="latestCategory">[<?php echo $latest['category']; ?>]</span><?php } ?>
<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $latest['no']; ?>">&middot; <?php echo cutString(stripslashes($latest['subject']), $cutSize); ?></a>	
	<?php if($latest['comment_count']) { ?><span class="latestCommentNum">(<?php echo $latest['comment_count']; ?>)</span><?php } ?>
	<?php if($getContent) { ?>
	<div class="latestContent"><?php echo cutString(stripslashes(strip_tags($latest['content'])), $cutContentSize); ?></div>
	<?php } ?>
	<span class="latestDate"><?php echo date($dateFormat, $latest['signdate']); ?></span>
</div>
<div class="latestClear"></div>
	<?php
} # while
?>