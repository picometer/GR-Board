<?php
// 상단 설정 @sirini
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 넘어온 변수 처리 @sirini
$id = $_GET['id'];
$error = strip_tags(urldecode($_GET['error']));
$prevPage = $_GET['prevPage'];
$setup = $GR->getArray('select head_file, head_form, '."foot_form, foot_file, theme from {$dbFIX}board_list where id = '$id'");

// 상단 설정 @sirini
if($id && ($setup['head_file'] or $setup['head_form'])) {
	$move = 'board.php?id='.$id;
	if($setup['head_file']) {
		ob_start();
		include $setup['head_file'];
		$content = ob_get_contents();
		ob_clean();
		echo str_replace('</head>', '<link rel="stylesheet" href="out_style.css" type="text/css" title="style" /></head>', $content);
	}
	if($setup['head_form']) {
		$theme = 'theme/'.$setup['theme'];
		echo str_replace('[theme]', $theme, $setup['head_form']);
	}
} else {
	$move = $fromPage;
	$title = 'Error 오류가 발생했습니다.';
	include 'html_head.php';
}
?>
<!-- 에러 출력 시작 -->
<div id="msgBox">

	<!-- 에러 보기 박스 -->
	<fieldset class="errorBox">
		<legend class="legend">오류 보고</legend>
		<br />
		<?php echo $error; ?>
	</fieldset>

	<div style="height: 10px"></div>

	<!-- 이전 화면으로 돌아가기 -->
	<div style="text-align:center;">
		<input type="button" value="처음 화면으로 돌아 갑니다" onclick="location.href='<?php echo 'http://'.$_SERVER['HTTP_HOST']; ?>'" class="goBack" />
	</div>

</div>

<?php
// 하단 설정
if($id)
{
	if($setup['foot_file']) include $setup['foot_file'];
	echo $setup['foot_form'];
}
else { ?></body></html><?php } ?>