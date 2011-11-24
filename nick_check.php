<?php
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();
$nickname = $_GET['nickname'];

// 닉네임 값이 있는지 확인한다. @sirini
$saveFetch = $GR->getArray("select id from {$dbFIX}member_list where nickname = '$nickname'");
$getMemberInfo = $GR->getArray('select nickname from '.$dbFIX.'member_list where no = \''.$_SESSION['no'].'\'');

// 문서설정 @sirini
$title = 'GR Board ID Check';
include 'html_head.php';
?>
<body>
<?php
if($saveFetch['id']) {
	if($nickname && $getMemberInfo['nickname'] && ($nickname == $getMemberInfo['nickname'])) {
		echo '<script type="text/javascript"> alert(\'이미 사용하고 계십니다.\');'.
		'window.close();	</script>';
	} else {
	echo '<script type="text/javascript"> alert(\'이미 '.$nickname.' (이)가 다른 사용자에 의해'.
		' 등록되어 있습니다.\\n\\n다른 닉네임을 사용하세요.\');'.
		'window.close();	</script>';
	}

} else {
	echo '<script type="text/javascript"> alert(\'등록가능한 닉네임 입니다.\\n\\n등록을 계속해 주세요.\');'.
		'window.close(); </script>';
}
?>
</body>
</html>