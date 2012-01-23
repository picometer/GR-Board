<?php
// 관리자인지 확인한다.
if($_SESSION['no'] != 1) { 
	header('HTTP/1.1 406 Not Acceptable');
	exit('관리자만 접근가능합니다.'); 
}
if(!defined('__GRBOARD__')) exit(); ?>
		
		<!-- 게시판 추가 -->
		<div class="mvBack" id="admAddBoard">
			<div class="mv">게시판 추가</div>
			<form id="addBoard" onsubmit="return isAddValue(this);" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="hidden" name="isAddBoard" value="1" />
			<div class="tableListLine">
				<div class="tableLeft" title="이 게시판이 속할 그룹을 지정합니다.">그룹지정</div>
				<div class="tableRight">
					<select name="addGroup">
					<?php
					$getGroup = $GR->query('select no, name from '.$dbFIX.'group_list');
					while($group = $GR->fetch($getGroup)) { ?>
						<option value="<?php echo $group['no']; ?>"><?php echo $group['name']; ?></option>
					<?php } ?>
					</select> (아래 '모두 변경' 클릭 시 지정된 그룹 내 각 게시판 설정을 동일하게 변경 합니다.)
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="게시판 ID 는 영문소문자와 숫자, 언더바로 작성할 수 있습니다.">게시판 ID</div>
				<div class="tableRight"><input type="text" class="input" title="영문소문자와 숫자의 조합으로만 입력해 주세요. (한글로 적지 마세요)" name="addBoardId" maxlength="48" /> (영문소문자와 숫자만 입력 가능합니다. 한글 인식 안됨)</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="테마(스킨) 으로 여러가지 용도의 활용이 가능합니다.">테마(스킨) 선택</div>
				<div class="tableRight">
				<select name="addTheme" onchange="themePreview(this.value);">
				<?php
				$themeListArr = array();
				$openThemeDir = @opendir('theme');
				while($themeList = @readdir($openThemeDir)) {
					if($themeList != '.' && $themeList != '..') $themeListArr[] = $themeList;
				}
				@closedir($openThemeDir);
				$cntTheme = @count($themeListArr);
				sort($themeListArr);
				for($th=0; $th<$cntTheme; $th++) {
					echo '<option value="'.$themeListArr[$th].'">'.$themeListArr[$th].'</option>';
				}
				?>
				</select>
				<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
				<input type="checkbox" name="sameAddTheme" value="1" /> 모두 변경</span>
				<div id="themePreview"></div>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="게시판 이름을 적어주세요. (예: 자유게시판)">게시판 이름</div>
				<div class="tableRight"><input type="text" class="input" title="게시판 이름을 이 곳에 작성해 주세요." name="addBoardName" maxlength="50" /></div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="목록에서 게시물 내용을 포함하여 모든 정보를 가져옵니다. 방명록 형태로 사용할 때 체크하세요.">방명록 형태</div>
				<div class="tableRight">
					<input type="checkbox" name="addIsFull" value="1" />  
					목록에서 게시물 내용까지 모두 가져옵니다. (<strong>속도저하</strong> / 방명록형태일 때 체크)
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddIsFull" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="체크하시면 게시물 내용을 볼 때 하단에 게시물 목록을 함께 출력합니다.">게시물 목록보기</div>
				<div class="tableRight">
					<input type="checkbox" name="addIsList" value="1" />  
					게시물을 볼 때 하단에 게시물 목록을 같이 볼지 설정합니다.
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddIsList" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="제목을 일정 글자수 이하로 줄일 수 있습니다.">제목 자르기</div>
				<div class="tableRight">
					<input type="text" class="input" size="3" maxlength="3" name="addCutSubject" value="0" /> 
					글 목록에서 제목을 일정 길이로 자릅니다. (0 : 사용안함)
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddCutSubject" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="한페이지에 출력할 게시물 개수를 입력하세요. (1 ~ 999)">페이지당 목록 수</div>
				<div class="tableRight">
					<input type="text" class="input" size="3" maxlength="3" name="addPageNum" value="10" />
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddPageNum" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="한페이지에 출력할 페이지 묶음수를 입력하세요. (1 ~ 999)">페이지 표시 수</div>
				<div class="tableRight">
					<input type="text" class="input" size="3" maxlength="3" name="addPagePerList" value="10" />
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddPagePerList" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="코멘트 볼 때 한페이지에 출력할 코멘트 개수를 입력하세요. (1 ~ 999)">코멘트 목록 수</div>
				<div class="tableRight">
					<input type="text" class="input" size="3" maxlength="3" name="addCommentPageNum" value="10" />
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddCommentPageNum" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="코멘트 볼 때 한페이지에 출력할 코멘트 페이지 묶음수를 입력하세요. (1 ~ 999)">코멘트 표시 수</div>
				<div class="tableRight">
					<input type="text" class="input" size="3" maxlength="3" name="addCommentPagePerList" value="5" />
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddCommentPagePerList" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="게시물을 특정 시간 이후로 삭제가 불가능하도록 정합니다.">게시물 삭제제한</div>
				<div class="tableRight">
					<input type="text" class="input" size="3" maxlength="2" name="addFixTime" value="0" />
					(기본 0: 사용하지 않음 / 1~99시간 사이에서 정하여 넣으면 됩니다.)
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddFixTime" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="이 게시판에 달리는 코멘트들의 정렬방식을 정합니다.">코멘트 정렬 방식</div>
				<div class="tableRight">
					<input type="radio" value="1" name="addCommentSort" checked="checked" /> 
					먼저 작성된 것이 제일 위로 
					<input type="radio" value="0" name="addCommentSort" /> 
					마지막에 작성된 것이 제일 위로 <span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddCommentSort" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="이 게시판에 올려진 글들을 RSS로 외부출력 허용할 것인지 정합니다.">RSS 외부출력</div>
				<div class="tableRight">
					<input type="checkbox" value="1" name="addIsRss" checked="checked" /> 
					체크하시면 이 게시판 글들을 RSS 로 외부에 보냅니다. <span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddIsRss" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="일반 사용자가 html 을 사용할 수 있도록 할 것인지, 어떤 태그를 허용할 건지 정합니다.">HTML 허용</div>
				<div class="tableRight">
					<input type="text" class="input" name="addIsHtml" maxlength="200" style="width: 180px" value="b,font,span,strong,img,a,br,p,div,hr,u,del,i,strike,ol,ul,li,blockquote" />
					비어있을 경우 html 태그를 모두 허용하지 않습니다.
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddIsHtml" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="글 작성시 쉽게 본문을 편집할 수 있도록 합니다.">웹에디터 사용</div>
				<div class="tableRight">
					<input type="checkbox" value="1" name="addIsEditor" checked="checked" />
					체크하지 않을 경우 웹에디터 대신 GR코드를 사용 합니다.
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddIsEditor" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="댓글 작성시 간단한 편집을 할 수 있도록 합니다.">댓글 웹에디터</div>
				<div class="tableRight">
					<input type="checkbox" value="1" name="addIsCoEditor" checked="checked" />
					체크할 경우 댓글(코멘트)을 달 때 간단한 위지윅 에디터를 사용하도록 합니다.
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddIsCoEditor" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="게시판 출력 이전에 출력할 파일의 위치를 적어 넣습니다. 제일 처음 출력됩니다.">상단 파일</div>
				<div class="tableRight">
					<input type="text" class="input" name="addHeadFile" maxlength="250" />
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddHeadFile" value="1" /> 모두 변경</span>
					<input type="checkbox" name="forLayoutHead" value="layout/<?php echo $layout['var']; ?>/head.board.php" id="forHead" onfocus="setForLayout(this, 'addHeadFile');" /><label for="forHead">레이아웃용으로 설정</label>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="게시판 출력 이전에 출력할 내용을 적습니다. 상단파일 다음으로 출력됩니다." style="height: 180px">상단 내용</div>
				<div class="tableRight">
					<textarea name="addHeadForm" class="textarea" rows="7" cols="90"><?php echo $headContent; ?></textarea>
					<div><span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddHeadForm" value="1" /> 모두 변경</span></div>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="게시판을 부른 후 출력할 내용을 적습니다. 게시판 출력 이후에 바로 출력됩니다." style="height:180px">하단 내용</div>
				<div class="tableRight">
					<textarea name="addFootForm" class="textarea" rows="7" cols="90"><?php echo $footContent; ?></textarea>
					<div><span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddFootForm" value="1" /> 모두 변경</span></div>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="게시판을 부른 후 출력할 파일의 위치를 적어 넣습니다. 제일 마지막에 출력됩니다.">하단 파일</div>
				<div class="tableRight">
					<input type="text" class="input" name="addFootFile" maxlength="250" />
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddFootFile" value="1" /> 모두 변경</span>
					<input type="checkbox" name="forLayoutFoot" value="layout/<?php echo $layout['var']; ?>/foot.board.php" id="forFoot" onfocus="setForLayout(this, 'addFootFile');" /><label for="forFoot">레이아웃용으로 설정</label>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="카테고리는 사용할 순서대로 작성하며 '|' (쉬프트 + \) 로 구분합니다. ">카테고리</div>
				<div class="tableRight">
					<input type="text" class="input" name="addCategory" size="30" maxlength="250"  /> (예 : 일반|질문|답변)
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="접근레벨을 제한할 수 있습니다. 선택한 숫자 이상의 레벨만 사용가능 합니다.">목록보기 제한</div>
				<div class="tableRight">
				<select name="addEnterLevel">
				<?php for($i=1; $i<100; $i++) { ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
				</select>
				(<strong>1</strong> 이면 비회원도 가능)
				<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
				<input type="checkbox" name="sameAddEnterLevel" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="글 내용을 볼 수 있는 대상을 제한할 수 있습니다. 선택한 숫자 이상의 레벨만 사용가능 합니다.">글내용보기 제한</div>
				<div class="tableRight">
				<select name="addViewLevel">
				<?php for($ii=1; $ii<100; $ii++) { ?>
					<option value="<?php echo $ii; ?>"><?php echo $ii; ?></option>
				<?php } ?>
				</select>
				(<strong>1</strong> 이면 비회원도 가능)
				<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
				<input type="checkbox" name="sameAddViewLevel" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="글쓰기 가능한 대상을 제한할 수 있습니다. 선택한 숫자 이상의 레벨만 사용가능 합니다.">글쓰기 제한</div>
				<div class="tableRight">
				<select name="addWriteLevel">
				<?php for($iii=1; $iii<100; $iii++) { ?>
					<option value="<?php echo $iii; ?>"><?php echo $iii; ?></option>
				<?php } ?>
				</select>
				(<strong>1</strong> 이면 비회원도 가능)
				<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
				<input type="checkbox" name="sameAddWriteLevel" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="코멘트 쓰기가능한 대상을 제한할 수 있습니다. 선택한 숫자 이상의 레벨만 사용가능 합니다.">코멘트쓰기 제한</div>
				<div class="tableRight">
				<select name="addCommentWriteLevel">
				<?php for($iiii=1; $iiii<100; $iiii++) { ?>
					<option value="<?php echo $iiii; ?>"><?php echo $iiii; ?></option>
				<?php } ?>
				</select>
				(<strong>1</strong> 이면 비회원도 가능)
				<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
				<input type="checkbox" name="sameAddCommentWriteLevel" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="첨부파일 다운로드를 특정 레벨 이상일 때만 가능하도록 할 수 있습니다. 선택한 숫자 이상의 레벨만 이 게시판에서 첨부파일을 받을 수 있습니다.">다운로드 제한</div>
				<div class="tableRight">
				<select name="addDownLevel">
				<?php for($d=1; $d<100; $d++) { ?>
					<option value="<?php echo $d; ?>"><?php echo $d; ?></option>
				<?php } ?>
				</select>
				(<strong>1</strong> 이면 비회원도 가능)
				<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
				<input type="checkbox" name="sameAddDownLevel" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="첨부파일을 받을 때 받는 사용자의 포인트를 차감하고, 게시물 작성자에게 그 만큼 채워줄 수 있습니다. 비회원은 이 경우 파일을 받을 수 없습니다.">받기 포인트</div>
				<div class="tableRight">
				<select name="addDownPoint">
				<?php for($p=0; $p<100; $p++) { ?>
					<option value="<?php echo $p; ?>"><?php echo $p; ?></option>
				<?php } ?>
				</select>
				(<strong>0</strong> 이면 비회원도 파일 받을 수 있음)
				<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
				<input type="checkbox" name="sameAddDownPoint" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="이 게시판을 관리할 관리자 ID 를 적습니다. (여러명일 경우 | (Shift + ￦) 로 구분)">관리자 ID</div>
				<div class="tableRight">
					<input type="text" class="input" name="addMaster" onkeydown="findID(this.value);" maxlength="255" />
					(예: heegeun|sirini|honggildong)
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddMaster" value="1" /> 모두 변경</span>
					<div id="findIDResult" style="display: none"></div>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="이 게시판에 첨부할 수 있는 필드 수를 정합니다.">파일첨부</div>
				<div class="tableRight">
				<select name="addNumFile">
				<option value="0">0</option>
				<?php for($ft=1; $ft<11; $ft++) { ?>
					<option value="<?php echo $ft; ?>"><?php echo $ft; ?></option>
				<?php } ?>
				</select> 개 (한번에 10개까지 업로드 가능)
				<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
				<input type="checkbox" name="sameAddNumFile" value="1" /> 모두 변경</span>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="tableListLine">
				<div class="tableLeft" title="이 게시판에 등록된 게시물과 댓글이 수정될 시, 게시물과 댓글에 수정여부를 기록할지 설정합니다.">댓글/게시물 수정기록</div>
				<div class="tableRight">
					<input type="checkbox" value="1" name="addIsHistory" checked="checked" />
				  체크하시면, 게시물과 댓글의 수정여부를 기록합니다.
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddIsHistory" value="1" /> 모두 변경</span>
					<div id="findIDResult" style="display: none"></div>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="tableListLine">
				<div class="tableLeft" title="이 게시판에 영문만입력된 게시물/댓글이 등록시, 차단할지 허용할지를 설정합니다.">영문 게시물 차단</div>
				<div class="tableRight">
					<input type="checkbox" value="1" name="addIsEnglish" checked="checked" />
				  체크하시면, 게시물과 댓글에 영문으로만 된 글이<br /> 작성될경우 차단합니다. (비회원 글쓰기에만 적용)
					<span class="sameBox" title="이 설정을 이 게시판이 속한 그룹 내에 소속된 게시판에 한해서 동일하게 적용합니다.">
					<input type="checkbox" name="sameAddIsEnglish" value="1" /> 모두 변경</span>
					<div id="findIDResult" style="display: none"></div>
				</div>
				<div class="clear"></div>
			</div>

			<div class="submitBox">
				<input type="submit" value="게시판 생성" title="게시판을 위의 설정대로 생성 합니다" />
			</div>
			</form>
		</div><!--# 게시판 추가 -->