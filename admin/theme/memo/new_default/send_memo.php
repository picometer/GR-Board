<!-- 가운데 정렬 -->
<div id="memobox">

	<!-- 폭 설정 (기본값 사용) -->
	<div style="padding:5px;">

		<!-- 타이틀 -->
		<div class="bigTitle">Send memo</div>

		<!-- 쪽지 보내기 박스 -->
		<fieldset id="sendingMemo">
			<legend class="legend"><?php echo $targetInfo['nickname']; ?>님에게 쪽지 보내기</legend>

			<div class="vSpace"></div>

			<form name="sendMemo" onsubmit="return checkMemo(this);" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="hidden" name="sendOk" value="1" />
			<input type="hidden" name="targetKey" value="<?php echo $_GET['target']; ?>" />
			<input type="hidden" name="targetName" value="<?php echo $targetInfo['nickname']; ?>" />
			<div class="tableListLine">
				<div class="divLeft">제목</div>
				<div class="divRight"><input type="text" name="subject" class="boxInput" /></div>
				<div style="clear:both;"></div>
			</div>
			<div class="tableListLine">
				<div class="divLeft">내용</div>
				<div class="divRight">
					<textarea name="content" class="textarea"></textarea>
				</div>
				<div style="clear: both"></div>
			</div>
			<div style="text-align: center"><input type="image" src="image/admin/memo_ok.gif" value="쪽지를 보냅니다." onmouseover="btnOver(this);" onmouseout="btnOut(this);" /></div>
			</form>

		</fieldset><!--# 쪽지 보내기 박스 -->

		<!-- 위아래 공백 -->
		<div style="height:10px;"></div>

	</div><!--# 폭 설정 -->

</div><!--# 가운데 정렬 -->

<script type="text/javascript" src="js/memo_check.js"></script>