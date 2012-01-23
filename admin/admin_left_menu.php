<?php
// 관리자인지 확인한다.
if($_SESSION['no'] != 1) { 
	header('HTTP/1.1 406 Not Acceptable');
	exit('관리자만 접근가능합니다.'); 
}
if(!defined('__GRBOARD__')) exit(); ?>

<body>

<!-- 가운데 정렬 -->
<div id="installBox">

	<!-- 폭 설정 -->
	<div class="sizeFix">

		<!-- 타이틀 -->
		<div class="bigTitle"><img src="image/admin/admin_grboard_logo.gif" alt="GR Board" /></div>

		<!-- 관리메뉴 -->
		<div id="admMenuTable">
			<div class="mv">관리메뉴</div>
			<div class="menu<?php echo ($_GET['v']==1)?'View':''; ?>"><a href="admin.php?v=1" title="관리자 메인화면으로 갑니다."><img src="image/admin/admin_main.gif" alt="" /> 관리화면</a></div>
			<div class="menu<?php echo ($_GET['v']==2)?'View':''; ?>"><a href="javascript:dbSaveOk();" title="GR Board 가 사용중인 테이블을 백업합니다."><img src="image/admin/admin_db_backup.gif" alt="" /> DB 백업</a></div>
			<div class="menu<?php echo ($_GET['v']==3)?'View':''; ?>"><a href="admin_group.php?v=3" title="그룹들을 관리합니다."><img src="image/admin/admin_group.gif" alt="" /> 게시판그룹관리</a></div>
			<div class="menu<?php echo ($_GET['v']==4)?'View':''; ?>"><a href="admin_board.php?v=4" title="게시판들을 관리합니다."><img src="image/admin/admin_board.gif" alt="" /> 게시판관리</a></div>
			<div class="menu<?php echo ($_GET['v']==5)?'View':''; ?>"><a href="admin_member_group.php?v=5" title="멤버 그룹들을 관리합니다."><img src="image/admin/admin_group_member.gif" alt="" /> 회원그룹관리</a></div>
			<div class="menu<?php echo ($_GET['v']==6)?'View':''; ?>"><a href="admin_member.php?v=6" title="멤버들을 관리합니다."><img src="image/admin/admin_user.gif" alt="" /> 회원관리</a></div>
			<div class="menu<?php echo ($_GET['v']==7)?'View':''; ?>"><a href="admin_poll.php?v=7" title="설문조사를 실시합니다."><img src="image/admin/admin_poll.gif" alt="" /> 설문조사</a></div>
			<div class="menu<?php echo ($_GET['v']==8)?'View':''; ?>"><a href="admin_code.php?v=8" title="최근게시물/외부로그인 등의 코드를 쉽게 생성합니다."><img src="image/admin/admin_code_create.gif" alt="" /> 코드생성</a></div>
			<div class="menu<?php echo ($_GET['v']==10)?'View':''; ?>"><a href="admin_report.php?v=10" title="신고된 게시물들을 한 눈에 확인합니다."><img src="image/icon/article_trace_icon.gif" alt="" /> 신고 목록</a></div>
			<div class="menu"><a href="update/" title="GR Board 를 업데이트 합니다." onclick="window.open(this.href, '_blank'); return false;"><img src="image/admin/mid_arrow.gif" alt="" /> GR Board 업데이트</a></div>
			<div class="menu"><a href="logout.php" title="로그아웃 합니다."><img src="image/admin/admin_logout.gif" alt="" /> 로그아웃</a></div>
			<div class="menu"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>" title="사이트 첫화면으로 이동합니다."><img src="image/icon/visit_homepage_icon.gif" alt="" /> 웹사이트 첫화면</a></div>
			<div class="menu"><a href="http://sirini.net" onclick="window.open(this.href, '_blank'); return false;" title="GR시리즈 커뮤니티 사이트를 방문합니다."><img src="image/admin/admin_sirini_net.gif" alt="" /> 시리니넷</a></div>
			<div class="menu"><a href="javascript:deleteBoard();" title="GR Board 를 삭제합니다."><img src="image/admin/admin_delete.gif" alt="" /> GR Board 삭제</a></div>
		</div><!--# 관리메뉴 -->

		<!-- 우측 몸통 부분 -->
		<div id="admBody">