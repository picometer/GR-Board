<?php
// 쪽지알림 레이어 표시여부
$msg_poupop = "1"; // 설정할경우 1, 설정하지 않을경우 빈값

// 이동할 주소 정하기
$boardTargetID = $_GET['id'];
if($boardTargetID) $move = 'board.php?id='.$boardTargetID;
else $move = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
?>
<div class="loginTitle">좋은 하루 되세요!</div>
<div class="loginLeft">ID</div>
<div class="loginRight"><?php echo $login['id']; ?></div>
<div class="loginClear"></div>
<div class="loginLeft">Name</div>
<div class="loginRight"><?php echo $login['nickname']; ?></div>
<div class="loginClear"></div>
<div class="loggedTag">(L:<?php echo $login['level']; ?>, P:<?php echo $login['point']; ?>)</div>
<div class="loginAlign">
<a href="#" onclick="window.open('<?php echo $grboard; ?>/info.php','my_info','width=650,height=600,menubar=no');"><img src="<?php echo $grboard; ?>/outlogin/sirini_outlogin2/modify.gif" alt="정보수정" /></a>
<a href="#" onclick="location.href='<?php echo $grboard; ?>/logout.php?page=<?php echo $move; ?>'"><img src="<?php echo $grboard; ?>/outlogin/sirini_outlogin2/logout.gif" alt="로그아웃" /></a>
</div>
