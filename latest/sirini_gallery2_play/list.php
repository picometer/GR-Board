<div class="latestGalleryTitle"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>"><?php echo $latestTitle; ?></a></div>
<?php
// 최근갤러리에 쓰일 GD 썸네일 엔진 부르기
include_once './thumbnail.php';

// 게시물 루프
while($latest = mysql_fetch_array($getData))
{
	// 각 게시물당 첨부파일 첫번째 것 가져와서 처리
	$target = $latest['no'];
	$file = @mysql_fetch_array(mysql_query("select file_route1 from {$dbFIX}pds_save where id = '$id' and article_num = '$target'"));
	?>
<div class="latestGalleryPhoto"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $latest['no']; ?>">
<?php echo makeLatestThumb($grboard."/".$file['file_route1'], $path, $id, $grboard, 100, 100); ?></a></div>
	<?php
} # while
?>
<div class="latestGalleryClear"></div>