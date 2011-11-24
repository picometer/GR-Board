<?php
// '/' 로 구분해서 경로 저장 @sirini
$arrPath = @explode('/', $_SERVER['PATH_INFO']);
$cntSlash = @count($arrPath);
$grboard = str_replace('/'.end(explode('/', $_SERVER['REQUEST_URI'])), '', $_SERVER['REQUEST_URI']);

// 실제 경로를 불러 버퍼에 저장한 후 가공 처리, 출력 @sirini
@ob_start();

// 주로 게시판과 관련된 작업 $arrPath[1] 에는 게시판 ID가 들어감 @sirini
if($arrPath[2]) {
	// 공통적으로 쓰이는 변수 정의 @sirini
	$_GET['id'] = $arrPath[1];
	$_GET['boardID'] = $arrPath[1];

	switch($arrPath[2]) {
		case 'list': include 'board.php'; break;
		case 'rss': include 'rss.php'; break;
		case 'login': include 'login.php'; break;
		case 'write': include 'write.php'; break;

		case 'read':
			$_GET['articleNo'] = $arrPath[3];
			include 'board.php';
		break;		

		case 'category':
			$_GET['clickCategory'] = $arrPath[3];
			include 'board.php';
		break;

		case 'search':
			$_GET['searchOption'] = $arrPath[3];
			$_GET['searchText'] = $arrPath[4];
			include 'board.php';
		break;

		case 'trackback':
			$_GET['no'] = $arrPath[3];
			$_GET['grkey'] = $arrPath[4];
			include 'trackback.php';
		break;
	}
}
// 게시판과 상관 없는 작업 @sirini
else {
	switch($arrPath[1]) {
		case 'install': include 'install.php'; break;
		case 'config': include 'admin.php'; break;
		case 'rss': include 'rss.php'; break;
		case 'login': include 'login.php'; break;
		case 'logout': include 'logout.php'; break;
	}
}

// 출력하기 @sirini
$content = @ob_get_contents();
@ob_end_clean();
$_grboard = str_replace('/'.$_GET['id'], '', $grboard);
if($arrPath[2]) $_grboard = str_replace('/'.$arrPath[2], '', $_grboard);
if($arrPath[3]) $_grboard = str_replace('/'.$arrPath[3], '', $_grboard);
$content = str_replace('/mod_rewrite.php', '', $content);
$content = str_replace($grboard, $_grboard, $content);
echo $content;
?>