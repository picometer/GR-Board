<?php
// 기본 클래스를 불러온다. @sirini
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 만약 이미 로긴되어 있다면 경고페이지로 이동한다. @sirini
if($_SESSION['uniqKey'] && $_COOKIE['memberKey']) if($_SESSION['uniqKey'] == $_COOKIE['memberKey']) $GR->error('이미 로그인 되어 있습니다.', 0, 'CLOSE');

// 멤버 가입 설정 가져오기 @sirini
include 'config_member.php';

// passwd 디렉토리 퍼미션이 707이 아니면 닫기 @sirini
if(!is_writable('./passwd')) $GR->error('passwd 디렉토리의 퍼미션이 707 이 아닙니다.', 1, 'CLOSE');

// GR Board 위치 변수 저장
$grboard = str_replace('/'.end(explode('/', $_SERVER['REQUEST_URI'])), '', $_SERVER['REQUEST_URI']);
$pathArr = @explode('/', $grboard);
if(count($pathArr) > 1) $grboard = '/'.$pathArr[1];

// 비밀번호 확인시 (이메일을 통해 확인 시도시) @sirini
if($_GET['findID'] && $_GET['confirmKey']) {
	$findID = $_GET['findID'];
	if(!file_exists('./passwd/'.$findID.'.php')) $GR->error('비밀번호 찾기를 하지 않으셨습니다.', 0, 'CLOSE');
	include './passwd/'.$findID.'.php';
	if($matchKey == $_GET['confirmKey']) {
		$newPass = substr($matchKey, -8);
		$GR->query("update {$dbFIX}member_list set password = password('$newPass') where id = '".$findID."' limit 1");
		@unlink('./passwd/'.$findID.'.php');
		$GR->error('정상적으로 비밀번호를 변경했습니다. 다음 로그인부터 사용 가능이 가능합니다.', 0, 'CLOSE');
	} else $GR->error('키 값이 일치하지 않습니다.', 0, 'CLOSE');
}

// 조회하기 @sirini
if(array_key_exists('findNow', $_POST) && $_POST['findNow']) {
	$id = trim($_POST['id']);
	$jumin = trim($_POST['jumin']);
	if(!$id) $GR->error('아이디를 입력해 주세요', 0, $grboard.'/find_password.php');
	$findResult = $GR->getArray("select no, id, realname, email from {$dbFIX}member_list where id = '$id'");
	$adminMailAddress = @end($GR->getArray('select email from '.$dbFIX.'member_list where no = 1'));

	// 아이디를 찾았다 @sirini
	if($findResult['no']) {
		$key = md5(time());
		$newPass = substr($key, -8);
		$mailHeader  = 'MIME-Version: 1.0' . "\r\n";
		$mailHeader .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$mailHeader .= 'To: '.$findResult['id'].' <'.$findResult['email'].'>' . "\r\n";
		$mailHeader .= 'From: '.$_SERVER['HTTP_HOST'].' <'.$adminMailAddress['email'].'>' . "\r\n";
		$mailHeader .= 'Content-Transfer-Encoding: base64' . "\r\n";
		$mailSubject = '[http://'.$_SERVER['HTTP_HOST'].'] 비밀번호 찾기 답변 메일입니다. (GR Board Find Password)';
		$mailSubject = '=?utf-8?B?'.base64_encode($mailSubject).'?='; //제목 깨지는거 방지
		$mailMsg = '안녕하세요 '.$_SERVER['HTTP_HOST'].' 입니다. 비밀번호를 잊으셨나요?<br />'.
			'아래 제공되는 URL 을 클릭하시면 제공된 새 비밀번호로 덮어씌워지게 됩니다.<br /><br /><div style="border: #aaa 1px dotted; padding: 10px; background-color: #fafafa">'.
			'<a href="http://'.$_SERVER['HTTP_HOST'].$grboard.'/find_password.php?findID='.$id.'&amp;confirmKey='.$key.'">http://'.
			$_SERVER['HTTP_HOST'].$grboard.'/find_password.php?findID='.$id.'&amp;confirmKey='.$key.'</a></div><br /><br />'.
			'<strong>새 비밀번호:</strong> <span style="color: blue; letter-spacing: 3px; font-size: 16pt">'.$newPass.'</span><br /><br /><br />※ 위의 URL을 반드시 클릭하여 확인창을 보신 후, 새 비밀번호를 이용하여 로그인해 주세요!<br />발급 받으신 비밀번호로 사이트에 로그인 해 주신 후에는<br />원하시는 비밀번호로 교체하시면 됩니다.<br /><br />'.
			'감사합니다.<br /><br /><span style="color: #999">Powered by <a href="http://sirini.net" style="color: #999">GR Board</a> '.$GR->grInfo().'</span>';
		$mailMsg = chunk_split(base64_encode($mailMsg));  //base64인코딩 
		
		// 메일 보내기 실패시 에러메시지가 출력됨. @sirini
		mail($findResult['email'], $mailSubject, $mailMsg, $mailHeader);

		$fpPass = @fopen('passwd/'.$id.'.php', 'w');
		@fwrite($fpPass, '<?php $matchKey = \''.$key.'\'; ?>');
		@fclose($fpPass);
		$GR->error('가입 시 입력하신 '.$findResult['email'].' 메일 주소로 안내해 드리겠습니다.', 0, $grboard.'/find_password.php?newPass=done&mail='.$findResult['email']);
	
	// 못 찾았다 @sirini
	} else $GR->error('아이디가 없습니다.', 0, $grboard.'/find_password.php?newPass=0');

// 검색 후 @sirini
} else {
	if($_GET['newPass']) $newPass = $_GET['newPass'];
}

$title = 'GR Board Find Password';
include 'html_head.php';
?>
<body>
<!-- 중앙배열 -->
<div id="installBox">

	<!-- 폭 설정 -->
	<div style="width:99%; margin:auto;">

		<!-- 타이틀 -->
		<div class="bigTitle">Find password</div>

		<!-- 비밀번호찾기 -->
		<fieldset class="fieldset">
			<legend class="legend">비밀번호 찾기</legend>
			<div style="overflow:auto; height:130px">
			<?php 
			if(isset($newPass) && $newPass) {
				echo '<br /><strong>새 비밀번호를 사용하실 수 있습니다.</strong><br /><br />'.
					'이메일 ('.$_GET['mail'].') 로 전달된 새 비밀번호를 확인해 주세요.<br /><br />'.
					'<a href="#" onclick="window.close()">[클릭하시면 창을 닫습니다]</a>';
			} 
			elseif(isset($newPass) && !$newPass) {
				echo '<br />아이디가 올바르지 않아 찾을 수 없었습니다.<br /><br />'.
					'<strong>다시 입력해 보세요.</strong>';
			}
			else { ?>
			<br />비밀번호를 잊으셨을 경우 본인의 아이디와 가입 시 이메일을 이용하여 새로 설정하실 수 있습니다.<br />
			<br />
			<span style="color: green">※ 아이디를 입력한 이후 진행 안내</span><br />
			<br />
			아이디가 있을 경우, 멤버 등록시 기입하셨던 이메일로 비밀번호 갱신용 URL 주소와<br />
			자동으로 생성된 새 비밀번호가 보내집니다. 해당 이메일을 확인할 때 갱신용 URL 을 클릭하여<br />
			본인 확인 후, 같이 적혀진 새 비밀번호를 이용하여 로그인 하시면 됩니다.<br />
			(새로 제공받으신 비밀번호는 로그인하신 이후 본인이 사용할 비밀번호로 반드시 다시 변경해 주세요.)<br />
			<br />
			<?php } ?>
			</div>
		</fieldset><!--# 비밀번호찾기 -->

		<!-- 위아래 공백 -->
		<div style="height: 30px"></div>

		<?php if(!$newPass) { ?>
		<!-- 찾기 -->
		<form name="find" method="post" onsubmit="return inputCheck();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div style="text-align:center">
			<div style="width:450px;margin:auto">
				<div><input type="hidden" name="findNow" value="1" /></div>
				<div class="tableListLine">
					<div class="tableLeft">아이디</div>
					<div class="tableRight"><input type="text" name="id" class="input" style="width: 200px" title="본인의 아이디를 입력해 주세요." /></div>
					<div style="clear:both;"></div>
				</div>
				<div class="tableListLine">
					<div style="padding-top:10px">
						<input type="submit" class="submit" value="찾 기" />
					</div>
				</div>				
			</div>
		</div>
		</form>
		<!--# 찾기 -->
		<?php } ?>

	</div><!--# 폭 설정 -->

</div><!--# 중앙배열 -->

<script>
function inputCheck() {
	t = document.forms["find"];
	if(!t.elements["id"].value) {
		alert('아이디를 입력해 주세요');
		t.elements["id"].focus();
		return false;
	}
	if(!t.elements["jumin"].value) {
		alert('주민등록번호를 입력해 주세요');
		t.elements["jumin"].focus();
		return false;
	}
	return true;
}
</script>

</body>
</html>