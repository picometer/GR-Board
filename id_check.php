<?php
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

$id = $_GET['id'];

// ID 값이 있는지 확인한다. @sirini
$saveFetch = $GR->getArray("select id from {$dbFIX}member_list where id = '$id'");

// 문서설정 @sirini
$title = 'GR Board ID Check';
include 'html_head.php';
?>
<body>
<?php
if($saveFetch['id']) {
	echo '<script type="text/javascript"> alert(\'이미 '.$id.' 가 다른 사용자에 의해'.
		'등록되어 있습니다.\\n\\n다른 아이디를 사용하세요.\');'.
		'window.close();	</script>';
} else {
	echo '<script type="text/javascript"> alert(\'등록가능한 ID 입니다.\\n\\n등록을 계속해 주세요.\');'.
		'window.close(); </script>';
}
?>
</body>
</html>