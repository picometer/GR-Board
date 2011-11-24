<div style="padding: 10px">
<?php
// 게시물 루프
while($latest = mysql_fetch_array($getData))
{
	$title = stripslashes($latest['tag']);
	if($latest['count'] < 5) $tagLv = 1;
	elseif($latest['count'] > 4 && $latest['count'] < 10) $tagLv = 2;
	elseif($latest['count'] > 9 && $latest['count'] < 30) $tagLv = 3;
	elseif($latest['count'] > 29 && $latest['count'] < 50) $tagLv = 4;
	else $tagLv = 5;
	?>
<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $latest['id']; ?>&searchOption=tag&searchText=<?php echo urlencode($title); ?>" class="tagLv<?php echo $tagLv; ?>" title="<?php echo $latest['id']; ?> 게시판에서 사용된 태그"><?php echo $title; ?></a> &nbsp;
	<?php
} # while
?>
</div>