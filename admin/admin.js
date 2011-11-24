// DOM 아이디값으로 객체 반환
function _(id) {
	return document.getElementById(id);
}

// 삭제할건지 물어보기
function deleteBoard() {
	if(confirm('정말로 GR Board 를 삭제하시겠습니까?\n\n'+
		'GR Board 가 사용하고 있는 테이블과 DB 접속정보 모두 삭제됩니다.\n\n'+
		'완전한 삭제를 위해서는 ftp 로 접속 후 첨부파일을 포함하여 모두 삭제하세요.'+
		'\n\n삭제 후 설치 페이지로 이동합니다.')) {
		location.href='admin_uninstall.php';
	}
}

// DB 파일을 백업할 것인지 물어보기
function dbSaveOk() {
	if(confirm('GR Board 가 사용중인 DB 를 백업하시겠습니까?\n\n'+
		'예(Yes)를 누르시면 백업파일을 받으실 수 있으며\n\n'+
		'아니오(No)를 누르시면 현재 사용중인 DB 상태를 확인할 수 있습니다.\n\n'+
		'※ GR 보드 뿐만 아니라 사용하고 계시는 모든 DB 를 백업하시려면\n'+
		'이용중인 호스팅회사에서 제공하는 전용 매니져 프로그램이나,\n'+
		'phpMyAdmin 을 이용하시길 바랍니다.\n\n'+
		'(phpMyAdmin 은 대표적인 MySQL DB 서버 관리 도구이며,\n'+
		'http://phpmyadmin.net 에서 배포하고 있는 오픈소스 프로그램입니다.\n'+
		'시리니넷에서도 받으실 수 있습니다.)')) 	{
		location.href='admin_backup.php?db_save_ok=1';
	} else {
		location.href='admin_backup.php?v=2';
	}
}

// 현재 사용중인 세션파일들을 모두 삭제할 것인지 물어보기
function sessionDelete() {
	if(confirm('현재 사용중인 모든 세션파일들을 삭제하시겠습니까?\n\n'+
		'로그인된 멤버들은 모두 로그아웃 될 것이며\n\n'+
		'중복 조회, 투표 기록도 삭제하고 다시 기록을 시작합니다.\n\n'+
		'세션은 주기적으로 비워주는 것이 좋습니다.\n\n'+
		'예(Yes)를 누르시면 세션 삭제후 다시 로그인 하셔야 합니다.')) {
		location.href='admin.php?sessionDelete=1';
	}
}

// 기록된 오류 로그를 모두 삭제할 것인지 물어보기
function errorLogDelete() {
	if(confirm('기록된 모든 중요 오류 기록을 삭제하시겠습니까?\n\n'+
		'오류 기록은 GR Board 의 문제점이나 사용자들이 어디서 많은 문제점을 만나는지\n\n'+
		'어떤 IP 의 유저가 어떤 의도로 어떤 위치에 접근을 시도했는지\n\n'+
		'확실하게 파악할 수 있는 중요한 지표입니다.\n\n'+
		'만약 쓸데없는 로그가 많이 쌓였다고 판단될 경우에만 모두 삭제해 주세요.')) {
		location.href='admin.php?errorLogDelete=1';
	}
}

// 모든 게시판의 오류를 수정할 것인지 물어보기
function repairDB() {
	if(confirm('모든 게시판의 오류를 수정하고 최적화 하시겠습니까?\n\n'+
		'이 과정은 GR 보드가 사용하고 있는 테이블들의 오류를 수정하고\n\n'+
		'최적화 하는 과정입니다. 테이블의 수정이 있거나 변경사항이 있을 경우\n\n'+
		'한번씩 해 주시는 것이 좋습니다.\n\n'+
		'※ 실행 전 데이터들을 모두 백업받으시길 바랍니다.')) {
		location.href='admin.php?repairDB=1';
	}
}

// 오래된 쪽지 삭제할 것인지 물어보기
function memoDelete() {
	if(confirm('보관중인 오래된 멤버들의 쪽지를 삭제하시겠습니까?\n\n'+
		'각 멤버들에게 일주일 이전까지 도착했던 모든 쪽지를 삭제합니다.\n\n'+
		'쪽지함을 비우기 전에 멤버들에게 먼저 공지를 띄워주시는 것이 좋습니다.')) {
		location.href='admin.php?memoDelete=1';
	}
}

// 로그인 기록을 모두 삭제할 것인지 물어보기
function loginLogDelete() {
	if(confirm('현재까지 보관중인 로그인 접속 시간 기록들을 모두 삭제하시겠습니까?\n\n'+
		'로그인 기록이 삭제되면 내 정보 보기에서 최근에 로그인한 시간들이 모두 삭제됩니다.\n\n'+
		'접속자가 많은 사이트에서는 주기적으로 비워주시는 것이 좋습니다.\n\n'+
		'계속 진행하시겠습니까?')) {
		location.href='admin.php?loginLogDelete=1';
	}
}

// 트랙백을 모두 삭제할 것인지 물어보기
function deleteTrackback() {
	if(confirm('별도로 보관중인 트랙백들을 모두 삭제하시겠습니까?')) {
		location.href='admin.php?deleteTrackback=1';
	}
}

// btnOver , btnOut 이벤트 잡아채기
var inputBtn = document.getElementsByTagName('input');
for(i=0; i<inputBtn.length; i++) {
	if(inputBtn[i].getAttribute('class') == 'btn') {
		inputBtn[i].onmouseover = function() { this.setAttribute('src', str_replace('.gif', '_over.gif', this.getAttribute('src'))); }
		inputBtn[i].onmouseout = function() { this.setAttribute('src', str_replace('_over.gif', '.gif', this.getAttribute('src'))); }
	}
}

// 문자열 치환
function str_replace(str1, str2, str3) {
	var r = new RegExp(str1, 'g');
	return str3.replace(r, str2);
}

// 도움말 토글
function toggleHelp(id) {
	t = $('#'+id);
	if(t.is(':hidden')) t.fadeIn();
	else t.fadeOut();
}

// 임시 이미지 파일들을 정리할 것인지 물어보기
function cacheImgDelete() {
	if(confirm('이미지 썸네일 등의 목적으로 생성된 캐쉬 이미지들을 모두 정리하시겠습니까?\n\n'+
		'삭제된 캐쉬 이미지는 필요시 다시 생성되며, 원본은 삭제되지 않습니다.\n\n'+
		'효율적인 서버 자원 활용을 위해 주기적으로 정리해 주세요.\n\n'+
		'지금 정리하시겠습니까?')) {
		location.href='admin.php?cacheImgDelete=1';
	}
}

// 신고 목록들을 모두 제거할 것인지 물어보기
function reportListDelete() {
	if(confirm('신고 목록들을 모두 제거하시겠습니까?\n\n지금까지 들어온 신고된 게시물들을 모두 다 처리하신 후\n\n'+
		'목록이 필요 없으실 때 제거해 주세요.\n\n신고 목록만 제거하므로 게시물이 추가적으로 삭제된다거나 하지는 않습니다.\n\n지금 목록을 초기화 하시겠습니까?')) 	{
		location.href='admin.php?reportListDelete=1';
	}
}

// 컴퓨터 시간 조회
var now = new Date();
var TIME_STAMP = now.getTime();
$('#clientTime').html(now.getFullYear()+'-'+(now.getMonth()+1)+'-'+now.getDate()+' '+now.getHours()+':'+now.getMinutes()+':'+now.getSeconds());

// 서버 시간을 동기화할 때 물어보기
function timeSync(server) {
	var pc = parseInt(TIME_STAMP / 1000);
	var server = parseInt(server);
	var msg = '';
	var diff = pc - server;
	if(server > pc) msg = '서버가 관리자님 컴퓨터 시간보다 '+(server-pc)+'초 더 빠릅니다.\n\n';
	else if(server == pc) msg = '서버 시간과 관리자님 컴퓨터 시간이 초 단위까지 동일합니다. (마이크로초 단위 오차는 있음)\n\n';
	else msg = '서버가 관리자님 컴퓨터 시간보다 '+diff+'초 더 느립니다.\n\n';
	if(confirm(msg+'GR보드가 일할 때는 관리자님 시간대로 맞춰서 일을 하라고 할까요?')) {
		location.href='admin.php?timeSync=1&diff='+diff;
	}
}

// 링크 재정리 실행
function confirmTotalLatest()
{
	if(confirm('이미 삭제된 게시물/댓글을 가리키는 링크들을 정리하시겠습니까?')) {
		location.href='admin.php?confirmTotalLatestNow=1';
	}
}

// 페이지 로드 후 실행
$(function(){
	
	// 관리자 페이지 도움말 토글화
	$('#helpAdminBtn').toggle(
		function(){ $('#helpBox').fadeIn(); },
		function(){ $('#helpBox').fadeOut(); }
	);

});