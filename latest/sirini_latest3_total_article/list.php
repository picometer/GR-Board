<div class="latestTitle"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>"><?php echo $latestTitle; ?></a></div>
<?php
// 게시물 루프
while($latest = mysql_fetch_array($getData))
{
	$title = cutString(stripslashes($latest['subject']), $cutSize);
	$bbsName = get_bbs_name($latest['id']);
	?>
<div class="latestSubject">
<?php if($latest['is_secret']) { ?><img src="<?php echo $path; ?>/secret.gif" alt="비밀글" style="vertical-align: middle" /> <?php } else { ?>
<img src="<?php echo $path; ?>/arrow.gif" alt="" style="vertical-align: middle" />
<?php } echo $title; ?></a>
<span class="latestCommentNum">(<?php echo date($dateFormat, $latest['signdate']); ?>)</span>
</div>
	<?php
} # while
?>