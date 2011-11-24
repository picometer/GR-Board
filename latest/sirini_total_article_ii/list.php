<div class="latestTotalTitle"><?php echo $latestTitle; ?></div>
<?php
// 게시물 루프
while($latest = mysql_fetch_array($getData))
{
	$title = cutString(stripslashes($latest['subject']), $cutSize);
	$bbsName = get_bbs_name($latest['id']);
	?>
<div class="latestTotalSubject">
<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $latest['id']; ?>&amp;articleNo=<?php echo $latest['article_num']; ?>" title="게시판명: <?php echo $bbsName; ?>">
<?php if($latest['is_secret']) { ?><img src="<?php echo $path; ?>/secret.gif" alt="비밀글" style="vertical-align: middle" /> <?php } else { ?>
<img src="<?php echo $path; ?>/arrow.gif" alt="" style="vertical-align: middle" />
<?php } echo $title; ?></a>
<span class="latestTotalDate">(<?php echo date('m/d H:i:s', $latest['signdate']); ?>)</span>
</div>
	<?php
} # while
?>