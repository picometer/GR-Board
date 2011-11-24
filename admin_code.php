<?php
// 기본 클래스 @sirini
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 관리자인지 확인한다. @sirini
if($_SESSION['no'] != 1) $GR->error('관리자 화면은 관리자만 접근할 수 있습니다.', 1, 'CLOSE');

// 문서설정 @sirini
$title = 'GR Board Admin Page ( Code )';
include 'html_head.php';
include 'admin/admin_left_menu.php';
?>
		<!-- 현재 페이지 도움말 -->
		<div id="grboardHelpBox">
			여러분들의 .html(.php) 페이지에 쉽게 최근게시물/외부로그인 등을 달 수 있도록 코드를 생성해 줍니다. <a href="#" title="도움말을 더 봅니다" id="helpCodeBtn">...도움말보기 <img src="image/admin/btn_help_more.gif" alt="더 보기" /></a>
			<div id="helpBox" style="display: none">
			일반적으로 웹사이트를 제작하는 데 있어서 가장 까다로운 부분이 바로 최근게시물이나 외부로그인 입니다.<br />
			GR Board 에서는 사용자가 직접 .html(.php) 파일을 만들어 페이지를 제작할 때 HTML 과는 다른 생소한 코드를<br />
			보다 쉽고 편하게 다루실 수 있도록 이 코드 생성 페이지를 제공하고 있습니다.<br />
			<br />
			아래 각 패널별로 사용하고자 하는 테마를 선택하고, 갯수를 지정하고, 여러 옵션을 설정하면 마지막에<br />
			복사 후 붙여넣기 하여 바로 사용 할 수 있는 코드가 자동으로 생성 됩니다.<br />
			원하시는 페이지를 디자인 하신 후 코드 생성을 통해 간단하게 GR Board 최근게시물 등을 붙여보세요!
			</div>
		</div><!--# 현재 페이지 도움말 -->

		<!-- 코드 추천 -->
		<div class="mvBack" id="admCodeRecommand">
			<div class="mv">페이지 최상단 코드 추천</div>
			<div style="padding: 10px">
			<?php
			if(preg_match('/win/i', PHP_OS)) $bar = '\\'; else $bar = '/';
			$path = realpath(__FILE__);
			$pathArr = explode($bar, $path);
			$codeGrboard = $pathArr[count($pathArr)-2];
			?>
			<strong>&lt;?php<br />
			<span style="color: skyblue">$grboard</span> = <span style="color: brown">'./<?php echo $codeGrboard; ?>'</span>;</strong> <span style="color: green">// GR Board 디렉토리와 동급의 위치에 페이지 파일(예: index.php)이 있을 경우</span><br />
			<strong><span style="color: blue">include</span> <span style="color: skyblue">$grboard</span> . <span style="color: brown">'/include.php'</span>;<br />
			?&gt;</strong><br />
			<br />
			※ 아래의 코드는 &lt;head&gt; 와 &lt;/head&gt; 사이에 있는 &lt;style type="text/css"&gt; <strong>*여기에</strong> &lt;/style&gt; 넣어주세요.<br />
			<span style="color: #999">(최근게시물, 외부로그인 등의 테마 속에 있는 스타일시트를 페이지 내에 삽입(import)하는 예제구문 입니다.<br />
			위의 추천 코드와 아래 코드생성을 바탕으로 자동 생성된 코드이며, 자신의 페이지에 맞게 수정/추가 할 수 있습니다.)</span><br />
			<br />
			
			<div style="border: #ccc 2px solid; padding: 10px; background-color: #fafafa">
				<div>&lt;style type="text/css"&gt;<span style="color: green">/*&lt;![CDATA[*/</span></div>
				<div id="insertCSS1"></div>
				<div id="insertCSS2"></div>
				<div id="insertCSS3"></div>
				<div id="insertCSS4"></div>
				<div id="insertCSS5"></div>
				<div id="insertCSS6"></div>
				<div id="insertCSS7"></div>
				<div id="insertCSS8"></div>
				<div><span style="color: green">/*]]&gt;*/</span>&lt;/style&gt;</div>
				<div id="insertJS"></div>
			</div>

			</div>
		</div><!--# 코드 추천 -->

		<div class="vSpace"></div>

		<!-- 최근게시물 생성 -->
		<form id="codeLatest" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div class="mvBack" id="admLatestCode">
			<div class="mv">최근게시물 생성</div>

			<div class="tableListLine">
				<div class="tableLeft" title="사용할 최근게시물 테마를 선택합니다.">테마선택</div>
				<div class="tableRight">
					<select name="latestTheme">
					<?php
					$latestDir = @opendir('./latest/');
					while($latests = @readdir($latestDir)) { if($latests == '.' || $latests == '..') continue; ?>
					<option value="<?php echo $latests; ?>"><?php echo $latests; ?></option>
					<?php } ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="보여줄 게시판을 선택 합니다.">게시판 ID</div>
				<div class="tableRight">
					<select name="latestBoard">
					<?php
					$latestBoard = $GR->query('select id from '.$dbFIX.'board_list');
					while($bbs = $GR->fetch($latestBoard)) { ?>
					<option value="<?php echo $bbs['id']; ?>"><?php echo $bbs['id']; ?></option>
					<?php } ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="보여줄 게시물 수를 선택 합니다.">게시물 수</div>
				<div class="tableRight">
					<select name="latestNum">
					<?php
					for($i=1; $i<100; $i++) { ?>
					<option value="<?php echo $i; ?>"<?php echo (($i==5)?' selected="selected"':''); ?>><?php echo $i; ?></option>
					<?php } ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="제목을 특정 글자수 이하로 보이도록 제한을 겁니다.">제목 글자수 제한</div>
				<div class="tableRight">
					<input type="text" name="latestCutNum" class="input" value="0" /> (<strong>0</strong> 일 경우 글자수 제한 없음)
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="제목과 함께 글내용도 가져올 지 정합니다.">내용 가져오기</div>
				<div class="tableRight">
					<select name="latestGetContent"><option value="0">가져오지 않음</option><option value="1">내용 가져오기</option></select>
					(최근게시물 테마가 지원을 해야 사용 가능)
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="내용을 특정 글자수 이하로 보이도록 제한을 겁니다.">내용 글자수 제한</div>
				<div class="tableRight">
					<input type="text" name="latestCutContentNum" class="input" value="0" /> (<strong>0</strong> 일 경우 글자수 제한 없음, 최근게시물 테마가 지원을 해야 사용 가능)
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="날짜 형식을 변경할 수 있습니다.">날짜 형식 지정</div>
				<div class="tableRight">
					<input type="text" name="latestDateForm" class="input" value="Y.m.d" /> (<?php echo date('Y.m.d'); ?>)
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="최근게시물 테마 상단의 제목을 정합니다.">최근게시물 제목</div>
				<div class="tableRight">
					<input type="text" name="latestSubject" class="input" value="최근게시물" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="정렬할 때 어떤 대상을 기준으로 할 것인지 지정합니다.">정렬대상</div>
				<div class="tableRight">
					<select name="orderBy">
					<option value="no">글번호</option>
					<option value="name">글쓴이</option>
					<option value="homepage">홈페이지</option>
					<option value="signdate">작성시각</option>
					<option value="hit">조회수</option>
					<option value="good">추천수</option>
					<option value="comment_count">댓글수</option>
					<option value="category">분류명</option>
					<option value="subject">글제목</option>
					<option value="content">글내용</option>
					<option value="tag">태그</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="정렬할 때 역순으로 할 것인지, 순차적으로 할 것인지 정합니다.">정렬방법</div>
				<div class="tableRight">
					<select name="desc">
					<option value="desc">역순정렬 (기본)</option>
					<option value="asc">순차정렬</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="tableListLine">
				<div class="submitBox">
					<input type="submit" value="코드 생성" title="최근게시물 코드를 생성 합니다." />
				</div>
			</div>

			<div id="latestPreviewCode" class="codePreview">코드생성 을 클릭하시면 생성 됩니다.</div>

		</div><!--# 최근게시물 생성 -->
		</form>

		<div class="vSpace"></div>

		<!-- 외부로그인 생성 -->
		<form id="codeOutlogin" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div class="mvBack" id="admOutloginCode">
			<div class="mv">외부로그인 생성</div>

			<div class="tableListLine">
				<div class="tableLeft" title="사용할 최근게시물 테마를 선택합니다.">테마선택</div>
				<div class="tableRight">
					<select name="outloginTheme">
					<?php
					$outloginDir = @opendir('./outlogin/');
					while($outlogins = @readdir($outloginDir)) { if($outlogins == '.' || $outlogins == '..') continue; ?>
					<option value="<?php echo $outlogins; ?>"><?php echo $outlogins; ?></option>
					<?php } ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="tableListLine">
				<div class="submitBox">
					<input type="submit" value="코드 생성" title="외부로그인 코드를 생성 합니다." />
				</div>
			</div>

			<div id="outloginPreviewCode" class="codePreview">코드생성 을 클릭하시면 생성 됩니다.</div>

		</div><!--# 외부로그인 생성 -->
		</form>

		<div class="vSpace"></div>

		<!-- 통합 최근게시물 생성 -->
		<form id="codeTotalLatest" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div class="mvBack" id="admTotalLatestCode">
			<div class="mv">통합 최근게시물 생성</div>

			<div class="tableListLine">
				<div class="tableLeft" title="사용할 통합 최근게시물 테마를 선택합니다.">테마선택</div>
				<div class="tableRight">
					<select name="latestTotalTheme">
					<?php
					$latestTotalDir = @opendir('./latest/');
					while($latestTotals = @readdir($latestTotalDir)) { if($latestTotals == '.' || $latestTotals == '..') continue; ?>
					<option value="<?php echo $latestTotals; ?>"><?php echo $latestTotals; ?></option>
					<?php } ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="보여줄 게시물 수를 선택 합니다.">게시물 수</div>
				<div class="tableRight">
					<select name="latestTotalNum">
					<?php
					for($i=1; $i<100; $i++) { ?>
					<option value="<?php echo $i; ?>"<?php echo (($i==5)?' selected="selected"':''); ?>><?php echo $i; ?></option>
					<?php } ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="제목을 특정 글자수 이하로 보이도록 제한을 겁니다.">제목 글자수 제한</div>
				<div class="tableRight">
					<input type="text" name="latestTotalCutNum" class="input" value="0" /> (<strong>0</strong> 일 경우 글자수 제한 없음)
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="날짜 형식을 변경할 수 있습니다.">날짜 형식 지정</div>
				<div class="tableRight">
					<input type="text" name="latestTotalDateForm" class="input" value="Y.m.d" /> (<?php echo date('Y.m.d'); ?>)
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="통합 최근게시물 테마 상단의 제목을 정합니다.">통합 게시물 제목</div>
				<div class="tableRight">
					<input type="text" name="latestTotalSubject" class="input" value="통합 최근게시물" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="비밀글도 목록에 표시 합니다.">비밀글 보기</div>
				<div class="tableRight">
					<select name="latestTotalGetSecret"><option value="false">비밀글 숨기기</option><option value="true">비밀글 보여주기</option></select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="정렬할 때 어떤 대상을 기준으로 할 것인지 지정합니다.">정렬대상</div>
				<div class="tableRight">
					<select name="orderBy">
					<option value="no">글번호</option>
					<option value="name">글쓴이</option>
					<option value="homepage">홈페이지</option>
					<option value="signdate">작성시각</option>
					<option value="hit">조회수</option>
					<option value="good">추천수</option>
					<option value="comment_count">댓글수</option>
					<option value="category">분류명</option>
					<option value="subject">글제목</option>
					<option value="content">글내용</option>
					<option value="tag">태그</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="정렬할 때 역순으로 할 것인지, 순차적으로 할 것인지 정합니다.">정렬방법</div>
				<div class="tableRight">
					<select name="desc">
					<option value="desc">역순정렬 (기본)</option>
					<option value="asc">순차정렬</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="여기 지정된 ID의 게시판들 목록만 가져옵니다.">특정 게시판 지정</div>
				<div class="tableRight">
					<input type="text" name="boardList" class="input" value="" /> (지정예: freeboard<span style="color: blue">|</span>qna<span style="color: blue">|</span>notice<span style="color: blue">|</span>gallery)
					<div><br /><strong>※ 참고: 지정 가능한 게시판 ID들</strong> (비워둘 시 전체 게시판에서 추출, | <span style="color: #aaa">(Shift + ￦)</span> 로 구분합니다.)<br /><br />
					<?php
					$boardList = '';
					$loop = 1;
					$getBList = $GR->query('select id from '.$dbFIX.'board_list');
					while($bbs = $GR->fetch($getBList)) {
						$boardList .= '|'.$bbs['id'];
						if($loop % 5 == 0) $boardList .= '<br />';
						$loop++;
					}
					echo substr($boardList, 1, strlen($boardList));
					?></div>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="tableListLine">
				<div class="submitBox">
					<input type="submit" value="코드 생성" title="통합 최근게시물 코드를 생성 합니다." />
				</div>
			</div>

			<div id="latestTotalPreviewCode" class="codePreview">코드생성 을 클릭하시면 생성 됩니다.</div>

		</div><!--# 통합 최근게시물 생성 -->
		</form>

		<div class="vSpace"></div>

		<!-- 통합 최근코멘트 생성 -->
		<form id="codeTotalComment" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div class="mvBack" id="admTotalCommentCode">
			<div class="mv">통합 최근코멘트 생성</div>

			<div class="tableListLine">
				<div class="tableLeft" title="사용할 통합 최근코멘트 테마를 선택합니다.">테마선택</div>
				<div class="tableRight">
					<select name="latestTotalCommentTheme">
					<?php
					$latestTotalDir = @opendir('./latest/');
					while($latestTotals = @readdir($latestTotalDir)) { if($latestTotals == '.' || $latestTotals == '..') continue; ?>
					<option value="<?php echo $latestTotals; ?>"><?php echo $latestTotals; ?></option>
					<?php } ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="보여줄 게시물 수를 선택 합니다.">게시물 수</div>
				<div class="tableRight">
					<select name="latestTotalCommentNum">
					<?php
					for($i=1; $i<100; $i++) { ?>
					<option value="<?php echo $i; ?>"<?php echo (($i==5)?' selected="selected"':''); ?>><?php echo $i; ?></option>
					<?php } ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="제목을 특정 글자수 이하로 보이도록 제한을 겁니다.">제목 글자수 제한</div>
				<div class="tableRight">
					<input type="text" name="latestTotalCommentCutNum" class="input" value="0" /> (<strong>0</strong> 일 경우 글자수 제한 없음)
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="날짜 형식을 변경할 수 있습니다.">날짜 형식 지정</div>
				<div class="tableRight">
					<input type="text" name="latestTotalCommentDateForm" class="input" value="Y.m.d" /> (<?php echo date('Y.m.d'); ?>)
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="통합 최근코멘트 테마 상단의 제목을 정합니다.">통합 코멘트 제목</div>
				<div class="tableRight">
					<input type="text" name="latestTotalCommentSubject" class="input" value="통합 최근코멘트" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="비밀글도 목록에 표시 합니다.">비밀글 보기</div>
				<div class="tableRight">
					<select name="latestTotalCommentGetSecret"><option value="false">비밀글 숨기기</option><option value="true">비밀글 보여주기</option></select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="정렬할 때 어떤 대상을 기준으로 할 것인지 지정합니다.">정렬대상</div>
				<div class="tableRight">
					<select name="orderBy">
					<option value="no">글번호</option>
					<option value="name">글쓴이</option>
					<option value="homepage">홈페이지</option>
					<option value="signdate">작성시각</option>
					<option value="hit">조회수</option>
					<option value="good">추천수</option>
					<option value="comment_count">댓글수</option>
					<option value="category">분류명</option>
					<option value="subject">글제목</option>
					<option value="content">글내용</option>
					<option value="tag">태그</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="정렬할 때 역순으로 할 것인지, 순차적으로 할 것인지 정합니다.">정렬방법</div>
				<div class="tableRight">
					<select name="desc">
					<option value="desc">역순정렬 (기본)</option>
					<option value="asc">순차정렬</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="여기 지정된 ID의 게시판들 목록만 가져옵니다.">특정 게시판 지정</div>
				<div class="tableRight">
					<input type="text" name="boardList" class="input" value="" /> (지정예: freeboard<span style="color: blue">|</span>qna<span style="color: blue">|</span>notice<span style="color: blue">|</span>gallery)
					<div><br /><strong>※ 참고: 지정 가능한 게시판 ID들</strong> (비워둘 시 전체 게시판에서 추출, | <span style="color: #aaa">(Shift + ￦)</span> 로 구분합니다.)<br /><br />
					<?php
					$boardList = '';
					$loop = 1;
					$getBList = $GR->query('select id from '.$dbFIX.'board_list');
					while($bbs = $GR->fetch($getBList)) {
						$boardList .= '|'.$bbs['id'];
						if($loop % 5 == 0) $boardList .= '<br />';
						$loop++;
					}
					echo substr($boardList, 1, strlen($boardList));
					?></div>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="tableListLine">
				<div class="submitBox">
					<input type="submit" value="코드 생성" title="통합 최근코멘트 코드를 생성 합니다." />
				</div>
			</div>

			<div id="latestTotalCommentPreviewCode" class="codePreview">코드생성 을 클릭하시면 생성 됩니다.</div>

		</div><!--# 통합 최근코멘트 생성 -->
		</form>

		<div class="vSpace"></div>

		<!-- 설문조사 생성 -->
		<form id="codePoll" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div class="mvBack" id="admPollCode">
			<div class="mv">설문조사 생성</div>

			<div class="tableListLine">
				<div class="tableLeft" title="사용할 최근게시물 테마를 선택합니다.">테마선택</div>
				<div class="tableRight">
					<select name="pollTheme">
					<?php
					$pollDir = @opendir('./latest/');
					while($polls = @readdir($pollDir)) { if($polls == '.' || $polls == '..') continue; ?>
					<option value="<?php echo $polls; ?>"><?php echo $polls; ?></option>
					<?php } ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="tableListLine">
				<div class="submitBox">
					<input type="submit" value="코드 생성" title="설문조사 코드를 생성 합니다." />
				</div>
			</div>

			<div id="pollPreviewCode" class="codePreview">코드생성 을 클릭하시면 생성 됩니다.</div>

		</div><!--# 설문조사 생성 -->
		</form>

		<div class="vSpace"></div>

		<!-- 통합검색 생성 -->
		<form id="codeTotalSearch" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div class="mvBack" id="admAllSearch">
			<div class="mv">통합검색폼 생성</div>

			<div class="tableListLine">
				<div class="tableLeft" title="사용할 최근게시물 테마를 선택합니다.">테마선택</div>
				<div class="tableRight">
					<select name="allSearchTheme">
					<?php
					$allSearchDir = @opendir('./latest/');
					while($search = @readdir($allSearchDir)) { if($search == '.' || $search == '..') continue; ?>
					<option value="<?php echo $search; ?>"><?php echo $search; ?></option>
					<?php } ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="검색 결과수를 조정합니다.">검색 결과수 제한</div>
				<div class="tableRight">
					<input type="text" name="resultLimit" class="input" value="10" />
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="tableListLine">
				<div class="submitBox">
					<input type="submit" value="코드 생성" title="통합검색 코드를 생성 합니다." />
				</div>
			</div>

			<div id="totalSearchPreviewCode" class="codePreview">코드생성 을 클릭하시면 생성 됩니다.</div>

		</div><!--# 통합검색 생성 -->
		</form>

		<div class="vSpace"></div>

		<!-- 태그 구름 생성 -->
		<form id="codeTag" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div class="mvBack" id="admTagCode">
			<div class="mv">태그구름 생성</div>

			<div class="tableListLine">
				<div class="tableLeft" title="사용할 최근게시물 테마를 선택합니다.">테마선택</div>
				<div class="tableRight">
					<select name="tagTheme">
					<?php
					$pollDir = @opendir('./latest/');
					while($polls = @readdir($pollDir)) { if($polls == '.' || $polls == '..') continue; ?>
					<option value="<?php echo $polls; ?>"><?php echo $polls; ?></option>
					<?php } ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="태그를 몇 개 출력할 것인지 숫자를 입력합니다.">출력 태그수</div>
				<div class="tableRight">
					<input type="text" name="latestTagNum" class="input" value="20" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="태그 구름 테마 상단의 제목을 정합니다.">태그 구름 제목</div>
				<div class="tableRight">
					<input type="text" name="latestTagSubject" class="input" value="태그구름" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="정렬할 때 어떤 대상을 기준으로 할 것인지 지정합니다.">정렬대상</div>
				<div class="tableRight">
					<select name="orderBy">
					<option value="no">등록번호</option>
					<option value="count">중복횟수</option>
					<option value="id">게시판ID</option>
					<option value="tag">태그</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="정렬할 때 역순으로 할 것인지, 순차적으로 할 것인지 정합니다.">정렬방법</div>
				<div class="tableRight">
					<select name="desc">
					<option value="desc">역순정렬 (기본)</option>
					<option value="asc">순차정렬</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="여기 지정된 ID의 게시판들 목록만 가져옵니다.">특정 게시판 지정</div>
				<div class="tableRight">
					<input type="text" name="boardList" class="input" value="" /> (지정예: freeboard<span style="color: blue">|</span>qna<span style="color: blue">|</span>notice<span style="color: blue">|</span>gallery)
					<div><br /><strong>※ 참고: 지정 가능한 게시판 ID들</strong> (비워둘 시 전체 게시판에서 추출, | <span style="color: #aaa">(Shift + ￦)</span> 로 구분합니다.)<br /><br />
					<?php
					$boardList = '';
					$loop = 1;
					$getBList = $GR->query('select id from '.$dbFIX.'board_list');
					while($bbs = $GR->fetch($getBList)) {
						$boardList .= '|'.$bbs['id'];
						if($loop % 5 == 0) $boardList .= '<br />';
						$loop++;
					}
					echo substr($boardList, 1, strlen($boardList));
					?></div>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="submitBox">
					<input type="submit" value="코드 생성" title="태그구름 코드를 생성 합니다." />
				</div>
			</div>

			<div id="latestTagPreviewCode" class="codePreview">코드생성 을 클릭하시면 생성 됩니다.</div>

		</div><!--# 태그구름 생성 -->
		</form>

		<div class="vSpace"></div>

		<!-- 현재 접속자 생성 -->
		<form id="nowConnect" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div class="mvBack" id="admTagCode">
			<div class="mv">현재 접속자 생성</div>

			<div class="tableListLine">
				<div class="tableLeft" title="사용할 현재 접속자 테마를 선택합니다.">테마선택</div>
				<div class="tableRight">
					<select name="nowConnectTheme">
					<?php
					$pollDir = @opendir('./latest/');
					while($polls = @readdir($pollDir)) { if($polls == '.' || $polls == '..') continue; ?>
					<option value="<?php echo $polls; ?>"><?php echo $polls; ?></option>
					<?php } ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="최대 몇 명까지 보여줄 것인지 정합니다. 10~20 사이가 좋습니다.">출력 목록수</div>
				<div class="tableRight">
					<input type="text" name="latestNowConnectNum" class="input" value="20" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="현재 접속자 테마 상단의 타이틀을 정합니다. 테마에 따라, 테마 내 지정된 그림으로 고정되는 경우도 있습니다.">현재 접속자 제목</div>
				<div class="tableRight">
					<input type="text" name="latestNowConnectSubject" class="input" value="현재 접속자 목록" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="정렬할 때 어떤 대상을 기준으로 할 것인지 지정합니다.">정렬대상</div>
				<div class="tableRight">
					<select name="orderBy">
					<option value="lastlogin">마지막 로그인 시간</option>
					<option value="no">멤버 고유번호</option>
					<option value="nickname">닉네임</option>
					<option value="realname">본명</option>
					<option value="point">포인트</option>
					<option value="level">레벨</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="tableLeft" title="정렬할 때 역순으로 할 것인지, 순차적으로 할 것인지 정합니다.">정렬방법</div>
				<div class="tableRight">
					<select name="desc">
					<option value="desc">역순정렬 (기본)</option>
					<option value="asc">순차정렬</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tableListLine">
				<div class="submitBox">
					<input type="submit" value="코드 생성" title="현재 접속자 코드를 생성 합니다." />
				</div>
			</div>

			<div id="latestNowConnectPreviewCode" class="codePreview">코드생성 을 클릭하시면 생성 됩니다.</div>

		</div><!--# 현재 접속자 생성 -->
		</form>

		</div><!--# 우측 몸통 부분 -->

		<div class="clear"></div>

	</div><!--# 폭 설정 -->	

</div><!--# 가운데 정렬 -->

<script type="text/javascript">//<![CDATA[
var GRBOARD = '<?php echo $codeGrboard; ?>';
//]]></script>

<script src="js/jquery.js"></script>
<script src="admin/admin_code.js"></script>

</body>
</html>