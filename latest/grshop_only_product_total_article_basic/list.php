<div class="latestTotalTitle"><?php echo $latestTitle; ?></div>
<?php
// 기본 변수설정
$width = 120;
$height = 100;
$strlen = 300;

// 게시물 루프
if($getData) {
while($latest = mysql_fetch_array($getData)) {
	$id = $latest['id'];
	$file = @mysql_fetch_array(mysql_query("select file_route from {$dbFIX}pds_extend where id = '$id' and article_num = '".$latest['article_num']."'"));
	$subject = stripslashes($latest['subject']);
	$cost = @mysql_fetch_array(mysql_query("select content, ext_money_original, ext_money_real from {$dbFIX}bbs_{$id} where no = ".$latest['article_num']));
	if(!$cost['ext_money_original']) continue;
	$content = cutString(strip_tags(stripslashes($cost['content'])), $strlen);
	$originalCost = number_format($cost['ext_money_original']);
	$saleCost = number_format($cost['ext_money_real']);
	?>
<div class="latestTotalBox">
	<div class="latestTotalPhoto"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $latest['article_num']; ?>" title="클릭하시면 이 상품의 상세정보를 봅니다.">
	<img src="<?php echo $grboard.'/phpThumb/phpThumb.php?src=../'.$grboard.'/'.$file['file_route'].'&amp;w='.$width.'&amp;h='.$height.'&amp;q=100&amp;fltr[]=usm|99|0.5|3'; ?>" alt="미리보기" /></a></div>
	<div class="latestTotalSubject">
		<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $latest['article_num']; ?>" title="클릭하시면 이 상품의 상세정보를 봅니다."><?php echo $subject; ?></a>
		<div class="latestTotalContent"><?php echo $content; ?></div>
	</div>
	<div class="latestTotalCost">
		<span class="latestTotalOriginalCost">판매가: <?php echo $originalCost; ?>원</span>
		<span class="latestTotalSaleCost">할인가: <?php echo $saleCost; ?>원</span>
	</div>
	<div style="clear: left"></div>
</div>
<?php } } ?>