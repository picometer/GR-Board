<div class="latestTop"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>"><?php echo $latestTitle; ?></a></div>
<?php
// 게시물 루프
while($latest = mysql_fetch_array($getData))
{
	$title = cutString(stripslashes($latest['subject']), $cutSize);
	?>
<div class="latestSubject"><?php if($latest['category']) { ?><span class="latestName"><?php echo stripslashes($latest['category']); ?> | </span><?php } ?>
<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $latest['no']; ?>"><?php echo $title; ?></a>	
</div>
	<?php
} # while
?>