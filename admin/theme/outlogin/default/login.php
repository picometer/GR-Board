<?php
/**************
 * 기본 로그인 테마
 **************
- 이 파일은 grboard/login.php 위치에서 불려집니다.
- GR보드 기본 외부로그인 테마로서, 상/하단에 게시판 상/하단 HTML 코드(파일)가 그대로 나옵니다.
- 스타일시트는 이 파일과 동일한 위치의 style.css 파일 내용이 반영됩니다.
 */
if(!defined('__GRBOARD__')) exit();
?>

<!-- 로그인 시작 -->
<div id="loginBOX">

	<!-- 로그인 입력박스 -->
	<form name="boardLogin" method="post" onsubmit="return inputCheck();" action="<?php echo $grboard; ?>/login_ok.php">
	<div class="mvLoginBack" id="enterLoginInfo">
		<div class="loginBar"></div>
		<div><input type="hidden" name="boardID" value="<?php echo $boardID; ?>" />
		<input type="hidden" name="fromPage" value="<?php echo $fromPage; ?>" />
		<input type="hidden" name="goAdminPage" value="<?php echo $goAdminPage; ?>" /></div>

		<div>
			<div class="tableLeft">아이디</div>
			<div class="tableRight"><input type="text" name="id" class="input" style="width: 180px" /></div>
			<div style="clear: both"></div>
		</div>

		<div>
			<div class="tableLeft">비밀번호</div>
			<div class="tableRight"><input type="password" name="password" class="input" style="width: 180px" /></div>
			<div style="clear: both"></div>
		</div>

		<div class="loginBottom">
			<input type="checkbox" name="auto_login" id="auto_login" value="1" onclick="auto_ok(this);" /> <label for="auto_login" style="cursor: help" title="사용중이신 브라우저에서 로그인 시 자동으로 로그인 합니다">자동로긴</label>
			<input type="image" src="<?php echo $grboard; ?>/image/admin/btn_ok.gif" title="로그인 합니다" onmouseover="btnOver(this);" onmouseout="btnOut(this);" />
			<img src="<?php echo $grboard; ?>/image/admin/btn_cancel.gif" alt="취소" onmouseover="btnOver(this);" onmouseout="btnOut(this);" onclick="location.href='<?php echo $move; ?>'" />
			<img src="<?php echo $grboard; ?>/image/admin/btn_find_password.gif" alt="비밀번호찾기" onmouseover="btnOver(this);" onmouseout="btnOut(this);" onclick="window.open('find_password.php', 'find_password', 'width=650,height=700,menubar=no');" />
		</div>
	</div>
	</form><!--# 로그인 입력박스 -->

</div><!--# 로그인 시작 -->