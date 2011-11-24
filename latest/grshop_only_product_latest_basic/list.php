<div class="latestGalleryTitle"><?php echo $latestTitle; ?></div>
<?php
// 크기 설정
$width = 140;
$height = 130;

// 게시물 루프
if($getData) {
while($latest = mysql_fetch_array($getData)) {
	$file = @mysql_fetch_array(mysql_query("select file_route from {$dbFIX}pds_extend where id = '$id' and article_num = '".$latest['no']."'"));
	$subject = stripslashes($latest['subject']);
	$cost = @mysql_fetch_array(mysql_query("select ext_money_original, ext_money_real from {$dbFIX}bbs_{$id} where no = ".$latest['no']));
	$originalCost = number_format($cost['ext_money_original']);
	$saleCost = number_format($cost['ext_money_real']);
	?>
	<div class="latestGalleryPhoto" style="width: <?php echo $width+5; ?>px; height: <?php echo $height+80; ?>px"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $latest['no']; ?>" title="클릭하시면 이 상품의 상세정보를 봅니다.">
	<img src="<?php echo $grboard.'/phpThumb/phpThumb.php?src=../'.$grboard.'/'.$file['file_route'].'&amp;w='.$width.'&amp;h='.$height.'&amp;q=100&amp;fltr[]=usm|99|0.5|3'; ?>" alt="미리보기" /></a>
		<div class="latestGallerySubject"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $latest['no']; ?>" title="클릭하시면 이 상품의 상세정보를 봅니다."><?php echo $subject; ?></a></div>
		<div class="latestOriginalCost">판매가: <?php echo $originalCost; ?>원</div>
		<div class="latestSaleCost">할인가: <?php echo $saleCost; ?>원</div>
	</div>
<?php } } ?>
<div style="clear: left"></div>