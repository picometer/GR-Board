<div id="mainFrame">
	<div id="mainImage"><img src="../<?php echo $config['mainImage']; ?>" alt="사이트 로고" /></div>

<?php
// 중간 최근 게시물 출력
if($config['useLatest']) { 
	$boards = @explode('|', $config['showBoard']);
	$cntBoard = count($boards)-1;
	for($b=0; $b<$cntBoard; $b++) {
		latest($config['latest'], $boards[$b], $config['latestNum'], 0, 0, 0, 'm.d', '<a href="../board.php?id='.$boards[$b].'">'.$boards[$b].'</a>');
		if($b > 0 && ($b+1) % 2 == 0) echo '<div class="clear"></div>';
	}
	if($b % 2 != 0) echo '<div class="clear"></div>';
}
?>
</div>
<div class="clear"></div>