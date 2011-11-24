<div class="latestGalleryTitle"><?php echo $latestTitle; ?></div>
<?php
// 크기 설정
$width = 160;
$height = 160;

// 게시물 루프
while($latest = mysql_fetch_array($getData)) {
	$file = @mysql_fetch_array(mysql_query("select file_route1 from {$dbFIX}pds_save where id = '$id' and article_num = '".$latest['no']."'"));
	?>
	<div class="latestGalleryPhoto"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $latest['no']; ?>">
	<img src="<?php echo $grboard.'/phpThumb/phpThumb.php?src=../'.$grboard.'/'.$file['file_route1'].'&amp;sx=0.3&amp;sy=0.3&amp;sw='.$width.'&amp;sh='.$height.'&amp;q=100&amp;fltr[]=usm|99|0.5|3'; ?>" alt="미리보기" /></a></div>
<?php } ?>