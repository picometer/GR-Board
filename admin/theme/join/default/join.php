<?php
/****************
 * 기본 멤버가입 테마
 ****************
- 이 파일은 grboard/join.php 위치에서 불려집니다.
- GR보드 기본 멤버가입 테마로서, 상/하단에 게시판 상/하단 HTML 코드(파일)가 그대로 나옵니다.
- 스타일시트는 이 파일과 동일한 위치의 style.css 파일 내용이 반영됩니다.
- 회원가입을 받지 않는 상태일경우, join_cancel_msg.txt 파일이 가입약관 부분에 읽혀지고 정보 입력은 받지 않습니다.
 */
if(!defined('__GRBOARD__')) exit();

// 게시판에서 불려지지 않았을 때
if(!$boardId) echo '<body>';

// 기본 처리
$joinTitle = '가입약관';
$joinText = @file_get_contents('join.txt');

// 회원가입을 받지 않을 때 처리
if(!$enableJoin) {
	$joinTitle = '안내 메시지';
	$joinText = @file_get_contents('join_cancel_msg.txt');
}
?>
<script type="text/javascript" src="./js/jquery.js"></script> 
<script type="text/javascript" src="./js/jquery.pstrength-min.1.2.js"></script> 
<script type="text/javascript">
$(function() {
$('.password').pstrength();
});
</script>
<!-- 중앙배열 -->
<div id="installBox">

	<!-- 폭 설정 -->
	<div id="joinBox">

		<!-- 타이틀 -->
		<div class="bigTitle">Join us</div>

		<!-- 약관 보기 박스 -->
		<fieldset class="fieldset">
			<legend class="legend"><?php echo $joinTitle; ?></legend>
			<div id="joinAgreement"><?php echo $joinText; ?></div>
		</fieldset><!--# 약관 보기 박스 -->

		<!-- 위아래 공백 -->
		<div class="vSpace"></div>

		<?php if($enableJoin) { ?>
		<!-- 정보 입력받기 -->
		<fieldset>
			<legend>정보입력</legend>
			<form id="join" method="post" onsubmit="return isValueForm(this);" action="join_ok.php" enctype="multipart/form-data">
			<div><input type="hidden" name="joinInBoard" value="<?php echo $joinInBoard; ?>" />
			<input type="hidden" name="boardId" value="<?php echo $boardId; ?>" />
			<input type="hidden" name="fromPage" value="<?php echo $fromPage; ?>" />
			<input type="hidden" name="enableJumin" value="<?php echo $enableJumin; ?>" />
			<input type="hidden" name="time" value="<?php echo $_time; ?>" /></div>
			<div class="tableListLine">
				<div class="tableLeft" title="자동등록방지코드 4자리를 입력해 주세요."><span>*</span>자동등록방지</div>
				<div class="tableRight"><input type="text" name="antiSpam" class="input" /> (입력해 주세요: <span class="antiCode"><?php echo $antiSpamKey; ?></span>)</div>
				<div class="clear"></div>
			</div>
			<div class="tableListLine">
				<div class="tableLeft" title="숫자+영문 조합 가능합니다."><span>*</span>아이디</div>
				<div class="tableRight"><input type="text" name="id" class="input" /> 
				<a href="#" onclick="alreadyIdCheck();" title="입력하신 ID 가 이미 등록되어 있는지 확인합니다.">
				[ID 중복확인]</a></div>
				<div class="clear"></div>
			</div>
			<div class="tableListLine">
				<div class="tableLeft" title="비밀번호는 최소 6자 이상으로 입력하셔야 합니다."><span>*</span>비밀번호</div>
				<div class="tableRight"><input type="password" name="password" class="input password" onblur="checkPassLength();" /> (※ 6자 이상 입력하세요)</div>
				<div class="clear"></div>
			</div>
			<div class="tableListLine">
				<div class="tableLeft" title="확인을 위해 비밀번호를 한 번 더 입력해 주세요."><span>*</span>비밀번호 확인</div>
				<div class="tableRight"><input type="password" name="passwordCheck" class="input" /></div>
				<div class="clear"></div>
			</div>
			<?php if($enableJumin) { ?>
			<div class="tableListLine">
				<div class="tableLeft" title="주민등록번호는 암호화되어 DB에 저장되므로, 관리자도 알 수 없습니다."><span>*</span>주민등록번호</div>
				<div class="tableRight"><input type="password" name="jumin" class="input" /> (※ 하이픈 '-' 없이 입력하세요)</div>
				<div class="clear"></div>
			</div>
			<?php } ?>
			<div class="tableListLine">
				<div class="tableLeft" title="별명(닉네임)은 되도록 건전하게 정해주세요."><span>*</span>별명</div>
				<div class="tableRight"><input type="text" name="nickname" class="input" />
				<a href="#" onclick="alreadyNickCheck();" title="입력하신 닉네임이 이미 등록되어 있는지 확인합니다.">
				[닉네임 중복확인]</a></div>
				<div class="clear"></div>
			</div>
			<div class="tableListLine">
				<div class="tableLeft" title="자신의 본명(실명)을 입력해주세요."><span>*</span>실명</div>
				<div class="tableRight"><input type="text" name="realname" class="input" /></div>
				<div class="clear"></div>
			</div>
			<div class="tableListLine">
				<div class="tableLeft" title="이메일주소를 입력해 주세요."><span>*</span>전자우편</div>
				<div class="tableRight"><input type="text" name="email" class="input" /></div>
				<div class="clear"></div>
			</div>
			<div class="tableListLine">
				<div class="tableLeft" title="홈페이지/블로그/미니홈피 주소를 입력해 주세요.">홈페이지</div>
				<div class="tableRight"><input type="text" name="homepage" class="input" /></div>
				<div class="clear"></div>
			</div>
			<div class="tableListLine">
				<div class="tableLeft" title="짧게 자신을 소개하는 문구나 시그네쳐용 문구를 작성해 주세요.">자기소개</div>
				<div class="tableRight">
				<textarea name="self_info" class="textarea" cols="45" rows="3"></textarea>
				<br />(200자)</div>
				<div class="clear"></div>
			</div>
			<?php if($enableNameTag) { ?>
			<div class="tableListLine">
				<div class="tableLeft" title="별명 대신에 출력할 작은 그림을 올려주세요.">네임택</div>
				<div class="tableRight"><input type="file" name="nametag" /> (80 x 20 이하)
				<?php if($member['nametag']) { ?>
				<br /><img src="<?php echo $member['nametag']; ?>" border="0" alt="" title="" /> <input type="checkbox" name="deleteNameTag" value="1" /> 네임택을 삭제합니다.
				<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php } if($enablePhoto) { ?>
			<div class="tableListLine">
				<div class="tableLeft" title="크지 않는 자신의 사진 혹은 시그네쳐용 사진을 올려주세요.">사진</div>
				<div class="tableRight"><input type="file" name="photo" /> (200 x 200 이하)
				<?php if(isset($member['photo'])) { ?>
				<br /><img src="<?php echo $member['photo']; ?>" border="0" alt="" title="" /> <input type="checkbox" name="deletePhoto" value="1" /> 사진을 삭제합니다.
				<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php } if($enableIcon) { ?>
			<div class="tableListLine">
				<div class="tableLeft" title="닉네임 앞에 출력할 작은 아이콘을 올려주세요.">아이콘</div>
				<div class="tableRight"><input type="file" name="icon" /> (16 x 16 이하)
				<?php if(isset($member['icon'])) { ?>
				<br /><img src="<?php echo $member['icon']; ?>" border="0" alt="" title="" /> <input type="checkbox" name="deleteIcon" value="1" /> 아이콘을 삭제합니다.
				<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php } ?>
			<div id="joinOK">
				<input type="image" src="image/admin/join_ok.gif" title="등록완료 합니다" onmouseover="btnOver(this);" onmouseout="btnOut(this);" />
			</div>
		</form>
		</fieldset><!--# 정보 입력받기 -->
		<?php } # if $enableJoin ?>

	</div><!--# 폭 설정 -->

</div><!--# 중앙배열 -->

<script type="text/javascript" src="js/join_check.js"></script>