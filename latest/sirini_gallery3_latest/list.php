<?php
// 게시물 루프
while($latest = mysql_fetch_array($getData)) {
	$file = @mysql_fetch_array(mysql_query("select file_route1 from {$dbFIX}pds_save where id = '$id' and article_num = '".$latest['no']."'"));
	?>
	<div class="latestGalleryPhoto"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $latest['no']; ?>">
	<img src="<?php echo $grboard.'/latest/'.$theme.'/phpThumb/phpThumb.php?src=../../../'.$grboard.'/'.$file['file_route1'].'&amp;w=110&amp;h=70&amp;q=100&amp;fltr[]=usm|99|0.5|3'; ?>" alt="미리보기" /></a></div>
	<?php } ?>
<div class="latestGalleryClear"></div>