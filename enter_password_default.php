<!-- 비밀번호 입력시작 -->
<div id="msgBox">

	<!-- 로그인 입력박스 -->
	<div id="inputPass" class="mvLoginBack">
		<div class="mv">비밀번호 입력</div>
		<form id="checkPassword" method="post" onsubmit="return inputCheck();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div><input type="hidden" name="enterPassword" value="1" />
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="page" value="<?php echo $page; ?>" />
		<input type="hidden" name="articleNo" value="<?php echo $articleNo; ?>" />
		<input type="hidden" name="readyWork" value="<?php echo $readyWork; ?>" />
		<input type="hidden" name="targetTable" value="<?php echo $targetTable; ?>" />
		<input type="hidden" name="modifyTarget" value="<?php echo $modifyTarget; ?>" />
		<input type="hidden" name="commentNo" value="<?php echo $commentNo; ?>" /></div>
		<br />
			
		<div class="tableListLine">
			<div class="tableLeft">비밀번호</div>
			<div class="tableRight"><input type="password" name="password" class="input" /></div>
			<div style="clear:both;"></div>
		</div>

		<div style="border-top:#e0e0e0 1px dotted;padding-top:10px;text-align:right;">
		<input type="submit" class="submit" value="확인" />
		<input type="button" class="submit" value="뒤로" onclick="location.href='board.php?id=<?php echo $_GET['id'].'&page='.$page; ?>';" />
		</div>

	</form>
	</div><!--# 로그인 입력박스 -->

</div><!--# 비밀번호 입력시작 -->

<script>
function inputCheck() {
	if(!document.forms["checkPassword"].elements["password"].value) {
		alert('비밀번호를 입력해 주세요.');
		return false;
	}
	return true;
}
document.forms["checkPassword"].elements["password"].focus();
</script>