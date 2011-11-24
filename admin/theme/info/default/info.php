<?php
/****************
 * 기본 멤버 정보확인 테마
 ****************
- 이 파일은 grboard/info.php 위치에서 불려집니다.
- GR보드 기본 멤버 정보확인 테마로서, 상/하단에 게시판 상/하단 HTML 코드(파일)가 그대로 나옵니다.
- 스타일시트는 이 파일과 동일한 위치의 style.css 파일 내용이 반영됩니다.
 */
if(!defined('__GRBOARD__')) exit();

// 게시판에서 불려지지 않았을 때
if(!$boardId) echo '<body>';
?>

<!-- 가운데 정렬 -->
<div id="installBox">

	<!-- 폭 설정 -->
	<div id="memberInfo">

		<!-- 타이틀 -->
		<div class="bigTitle">My information</div>

		<!-- 에러 보기 박스 -->
		<fieldset>
			<legend class="legend"><?php echo $member['realname']; ?> 님의 회원 정보</legend>

			<div class="vSpace"></div>
			
			<form id="info" name="memberInfo" onsubmit="return valueOk(this);" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
			<div><input type="hidden" name="modifyMemberInfo" value="1" />
			<input type="hidden" name="targetMemberNo" value="<?php echo $member['no']; ?>" />
			<input type="hidden" name="isEnableJumin" value="<?php echo $enableJumin; ?>" />
			<input type="hidden" name="boardId" value="<?php echo $boardId; ?>" /></div>

			<div class="tableListLine">
				<div class="tableLeft" title="한 번 정하신 아이디는 변경하실 수 없습니다.">ID</div>
				<div class="tableRight"><?php echo $member['id']; ?> <a href="javascript:outMe();">[탈퇴하기]</a></div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="보다 안전한 웹서핑을 위해, 주기적으로 비밀번호를 변경해 주세요.">비밀번호</div>
				<div class="tableRight"><input type="password" name="password" class="input" /> (입력 시 새 비밀번호로 수정됩니다)</div>
				<div class="clear"></div>
			</div>
			
			<?php if($enableJumin) { ?>
			<div class="tableListLine">
				<div class="tableLeft" title="본인의 주민등록번호를 입력해 주세요. (암호화되어 저장됩니다.)">주민등록번호</div>
				<div class="tableRight"><input type="password" id="jumin" name="jumin" value="<?php echo $member['jumin']; ?>" class="input" onfocus="isModify(this, 'memberInfo');" /> (※ 하이픈 '-' 없이 입력하세요)</div>
				<div class="clear"></div>
			</div>
			<?php } ?>

			<div class="tableListLine">
				<div class="tableLeft" title="자신의 현재 레벨을 확인하실 수 있습니다.">레벨</div>
				<div class="tableRight"><?php echo $member['level']; ?></div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="현재까지 쌓은 포인트를 확인하실 수 있습니다.">포인트</div>
				<div class="tableRight"><?php echo $member['point']; ?></div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="멤버로 등록한 날입니다.">등록일</div>
				<div class="tableRight"><?php echo date('Y년 m월 d일 __ H시 i분 s초', $member['make_time']); ?></div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="최근 로그인하신 시간들입니다." style="height: 210px">최근 로그인 기록</div>
				<div class="tableRight"><?php 
				$getLatestLogin = @mysql_query('select signdate from '.$dbFIX.'login_log where member_key = '.$member['no'].' order by no desc limit 10');
				while($loginList = @mysql_fetch_array($getLatestLogin)) {
					echo '<div class="mouseHelp" title="만약 자신이 이 시간에 로그인 한 적이 없다면, 해킹이 의심되므로 비밀번호를 좀 더 복잡한 것으로 변경해보세요!">'.date('Y년 m월 d일 / H시 i분 s초', $loginList['signdate']).'</div>';
				} ?></div>
				<div class="clear"></div>
			</div>

			<?php if($enableNameTag) { ?>
			<div class="tableListLine">
				<div class="tableLeft" title="자신의 닉네임 대신 나타낼 자그마한 그림 이름입니다. 규격 내 크기의 이미지가 제일 좋습니다.">네임택</div>
				<div class="tableRight"><input type="file" name="nametag" class="input" /> (80 x 20 이하)
				<?php if($member['nametag']) { ?>
				<br /><img src="<?php echo $member['nametag']; ?>" border="0" alt="" title="" /> <input type="checkbox" name="deleteNameTag" value="1" /> 네임택을 삭제합니다.
				<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php } if($enablePhoto) { ?>
			<div class="tableListLine">
				<div class="tableLeft" title="자신의 프로필 사진을 보여줍니다. 너무 크면 보기가 이상합니다.">사진</div>
				<div class="tableRight"><input type="file" name="photo" class="input" /> (200 x 200 이하)
				<?php if($member['photo']) { ?>
				<br /><img src="<?php echo $member['photo']; ?>" border="0" alt="" title="" /> <input type="checkbox" name="deletePhoto" value="1" /> 사진을 삭제합니다.
				<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php } if($enableIcon) { ?>
			<div class="tableListLine">
				<div class="tableLeft" title="이름 앞에 붙일 수 있는 아이콘입니다. 작은 아이콘일수록 보기가 더 좋습니다.">아이콘</div>
				<div class="tableRight"><input type="file" name="icon" class="input" /> (16 x 16 이하)
				<?php if($member['icon']) { ?>
				<br /><img src="<?php echo $member['icon']; ?>" border="0" alt="" title="" /> <input type="checkbox" name="deleteIcon" value="1" /> 아이콘을 삭제합니다.
				<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php } ?>
			<div class="tableListLine">
				<div class="tableLeft" title="자신의 본명이 아닌 별명입니다. 자신만의 개성을 잘 표현하는 닉네임을 지어보세요.">닉네임</div>
				<div class="tableRight"><input type="text" id="nickname" name="nickname" class="input" value="<?php echo $member['nickname']; ?>" />
				<a href="#" onclick="alreadyNickCheck();" title="입력하신 닉네임이 이미 등록되어 있는지 확인합니다.">
				[닉네임 중복확인]</a></div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="자신의 본명을 기입합니다. 자신의 이름에 부끄럽지 않은 예의 바른 네티켓 부탁드립니다.">실명</div>
				<div class="tableRight"><input type="text" id="realname" name="realname" class="input" value="<?php echo $member['realname']; ?>" /></div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="자신의 이메일 주소를 입력합니다. (예: example@email.com)">이메일</div>
				<div class="tableRight"><input type="text" id="email" name="email" class="input" value="<?php echo $member['email']; ?>" /></div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="자신의 홈페이지/블로그/미니홈피 주소를 기입합니다.">홈페이지</div>
				<div class="tableRight"><input type="text" name="homepage" class="input" value="<?php echo $member['homepage']; ?>" /></div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" style="height: 100px" title="짧고 간결한 문장으로 자신을 소개해 봅시다.">자기소개</div>
				<div class="tableRight"><textarea name="self_info" class="textarea" rows="5" cols="60"><?php echo stripslashes($member['self_info']); ?></textarea></div>
				<div class="clear"></div>
			</div>
			
			<div style="text-align: center">
			<input type="image" src="image/admin/info_modify.gif" title="정보를 수정합니다" onmouseover="btnOver(this);" onmouseout="btnOut(this);" />
			</div>

			</form>
		</fieldset><!--# 에러 보기 박스 -->

		<!-- 위아래 공백 -->
		<div style="height:10px;"></div>

	</div><!--# 폭 설정 -->

</div><!--# 가운데 정렬 -->

<script type="text/javascript" src="js/info_check.js"></script>