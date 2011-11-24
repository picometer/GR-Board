<?php
/**************
 * 기본 로그인 테마
 **************
- 이 파일은 grboard/login.php 위치에서 불려집니다.
- GR보드 기본 외부로그인 테마로서, 상/하단에 게시판 상/하단 HTML 코드(파일)가 그대로 나옵니다.
- 스타일시트는 이 파일과 동일한 위치의 style.css 파일 내용이 반영됩니다.

  스킨명 : New_default
  제작자 : DesginStudio == 이동규 == 장화신은고양이
  홈페이지 : studio-d.kr
 */
if(!defined('__GRBOARD__')) exit();
?>
<!-- 로그인 시작 -->
<!-- Design By_ DesignStudio (studio-d.kr) -->
<div id="login_box">
  <div class="login_header">
    <h2>로그인</h2>
    <p>"서비스를 이용하기 위해서는 로그인이 필요합니다."</p>
  </div>
  <div class="login_body">
    <noscript>
      <div id="outlogin_nojavascript">
        <p>사용하시고 계신 웹 브라우저에서는 Javascript를 지원하지 않습니다.</p>
        <p>로그인기능이 제대로 동작하지 않을 수 있습니다.</p>
      </div>
    </noscript>
    <form name="boardLogin" method="post" onsubmit="return inputCheck();" action="<?php echo $grboard; ?>/login_ok.php">
      <div>
        <input type="hidden" name="boardID" value="<?php echo $boardID; ?>" />
	      <input type="hidden" name="fromPage" value="<?php echo $fromPage; ?>" />
	      <input type="hidden" name="goAdminPage" value="<?php echo $goAdminPage; ?>" />
	    </div>
      <fieldset>
        <legend>로그인</legend>
        <dl>
          <dt>아이디</dt>
            <dd><input type="text" name="id" class="input_id" onclick="this.className='input_bg';" onkeydown="this.className='input_bg';" /></dd>
          <dt>비밀번호</dt>
            <dd><input type="password" name="password" class="input_password" onclick="this.className='input_bg';" onkeydown="this.className='input_bg';" /></dd>
        </dl>
        <div class="login_button_collect">
          <input type="checkbox" name="auto_login" id="auto_login" value="1" onclick="auto_ok(this);" /><label for="auto_login" title="사용중이신 브라우저에서 로그인 시 자동으로 로그인 합니다">자동로그인</label>
          <input type="image" id="login_button" src="<?php echo $grboard; ?>/admin/theme/outlogin/<?php echo $getOutlogin['var']; ?>/images/login.gif" title="로그인" />
        </div>
      </fieldset>
    </form>
    <ul>
      <li><a href="./find_password.php" title="비밀번호 찾기를 진행하시려면 여기를 눌러주세요." onclick="window.open('find_password.php', 'find_password', 'width=650,height=700,menubar=no'); return false;"><img src="<?php echo $grboard; ?>/admin/theme/outlogin/<?php echo $getOutlogin['var']; ?>/images/lost_password.gif" alt="비밀번호를 분실했어요." /></a></li>
      <li><a href="./join.php?fromPage=outlogin" title="회원가입을 진행하시려면 여기를 눌러주세요." onclick="window.open('join.php?fromPage=outlogin', 'find_password', 'width=650,height=650,menubar=no,scrollbars=yes'); return false;"><img src="<?php echo $grboard; ?>/admin/theme/outlogin/<?php echo $getOutlogin['var']; ?>/images/join.gif" alt="회원가입" /></a></li>
    </ul>
  </div>
  <?php if($move == NULL) { ?><a class="other_link" href="#outlogin_nojavascript" title="클릭시 두 번째 전의 페이지로 이동합니다." onclick="history.go(-2); return false;">로그인과정을 취소합니다.</a>
  <?php } else { ?><a class="other_ink" href="<?php echo $move; ?>">로그인과정을 취소합니다.</a><?php } ?>
</div>
<!-- 로그인 종료 -->
<!-- Design By_ DesignStudio (studio-d.kr) -->