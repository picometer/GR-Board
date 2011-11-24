<?php
// 기본 클래스를 부른다 @sirini
include 'class/common.php';
$GR = new COMMON;

// 로그인 상태가 아니면 에러 @sirini
if(!$_SESSION['no']) $GR->error('멤버만이 멤버의 정보를 볼 수 있습니다. 로그인 해 주세요.', 0, 'CLOSE');

$GR->dbConn();

// 회원의 정보를 가져온다. @sirini
$memberKey = $_GET['memberKey'];
$member = $GR->getArray("select * from {$dbFIX}member_list where no = '$memberKey'");

// 이메일 암호화
// 원문소스 : http://www.maurits.vdschee.nl/php_hide_email/
function hide_email($email) { 
	$character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
	$key = str_shuffle($character_set); $cipher_text = ''; $id = 'e'.rand(1,999999999);
	for ($i=0;$i<strlen($email);$i+=1) $cipher_text.= $key[strpos($character_set,$email[$i])];
	$script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";';
	$script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
	$script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';
	$script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")"; 
	$script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';
	return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;
}

// 문서설정 @sirini
$getInformation = $GR->getArray('select var from '.$dbFIX.'layout_config where opt = \'info_skin\' limit 1');
if(!$getInformation['var']) $getInformation['var'] = 'default';
$title = 'GR Board Member Page';
include 'html_head.php';
?>
<body>
<?php
// 회원정보 스킨 부르기 @sirini
include 'admin/theme/info/'.$getInformation['var'].'/member_info.php';
?>
</body>
</html>