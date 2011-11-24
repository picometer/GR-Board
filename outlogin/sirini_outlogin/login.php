<?php
// 이동할 주소 정하기
$boardTargetID = $_GET['id'];
if($boardTargetID) $move = 'board.php?id='.$boardTargetID;
else $move = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
?>
<form id="login" method="post" action="<?php echo $grboard; ?>/login_ok.php">
<div class="loginTitle">Welcome!</div>
<div class="loginSpace">
<input type="hidden" name="fromPage" value="<?php echo $move; ?>" />
<input type="hidden" name="boardID" value="<?php echo $boardTargetID; ?>" />
</div>
<div class="loginLeft">ID</div>
<div class="loginRight"><input type="text" name="id" class="loginInput" onfocus="this.style.backgroundColor='#f0f0f0'" onblur="this.style.backgroundColor=''" /></div>
<div class="loginClear"></div>
<div class="loginLeft">PW</div>
<div class="loginRight"><input type="password" name="password" class="loginInput" onfocus="this.style.backgroundColor='#f0f0f0'" onblur="this.style.backgroundColor=''" /></div>
<div class="loginClear"></div>
<div class="loginAlign"><input type="submit" value="로그인" class="loginSubmit" /> <input type="button" value="멤버등록" class="loginSubmit" onclick="window.open('<?php echo $grboard; ?>/join.php?fromPage=outlogin','join','width=650,height=650,menubar=no,scrollbars=no');" /></div>
</form>
