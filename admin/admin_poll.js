// DB 파일을 백업할 것인지 물어보기
function dbSaveOk()
{
	if(confirm('GR Board 가 사용중인 DB 를 백업하시겠습니까?\n\n'+
		'예(Yes)를 누르시면 백업파일을 받으실 수 있으며\n\n'+
		'아니오(No)를 누르시면 현재 사용중인 DB 상태를 확인할 수 있습니다.\n\n'+
		'※ GR 보드 뿐만 아니라 사용하고 계시는 모든 DB 를 백업하시려면\n'+
		'이용중인 호스팅회사에서 제공하는 전용 매니져 프로그램이나,\n'+
		'phpMyAdmin 을 이용하시길 바랍니다.\n\n'+
		'(phpMyAdmin 은 대표적인 MySQL DB 서버 관리 도구이며,\n'+
		'http://phpmyadmin.net 에서 배포하고 있는 오픈소스 프로그램입니다.\n'+
		'시리니넷에서도 받으실 수 있습니다.)'))
	{
		location.href='admin_backup.php?db_save_ok=1';
	}
	else
	{
		location.href='admin_backup.php?v=2';
	}
}

// 삭제할건지 물어보기
function deleteBoard()
{
	if(confirm('정말로 GR Board 를 삭제하시겠습니까?\n\n'+
		'GR Board 가 사용하고 있는 테이블과 DB 접속정보 모두 삭제됩니다.\n\n'+
		'완전한 삭제를 위해서는 ftp 로 접속 후 첨부파일을 포함하여 모두 삭제하세요.'+
		'\n\n삭제 후 설치 페이지로 이동합니다.'))
	{
		location.href='admin_uninstall.php';
	}
}

// 좌측 메뉴 마우스 온 이벤트
function Over(t)
{
	t.style.backgroundColor='#e5f0f7';
}

// 좌측 메뉴 마우스 아웃 이벤트
function Out(t)
{
	t.style.backgroundColor='';
}

// 설문 항목 추가
function addOption()
{
	TOTAL_INPUT++;
	t = document.getElementById('inputFields');
	t.innerHTML += '항목 #'+TOTAL_INPUT+': <input type="text" name="pollOption[]" title="필요 없으신 항목은 비워 두시면 됩니다." /><br />';
}

// 설문 삭제
function deletePoll(no)
{
	if(confirm('이 설문조사를 삭제하시겠습니까?\n\n'+
		'이 설문조사에 연관된 코멘트들도 모두 삭제됩니다.')) {
		location.href='admin_poll.php?deletePoll='+no;
	}
}

// 설문 항목 삭제
function deleteOption(no, go)
{
	if(confirm('이 항목을 제거하시겠습니까?')) {
		location.href='admin_poll.php?deleteOption='+no+'&go='+go;
	}
}

// 페이지 로드 후 실행
$(function(){

	// 도움말 토글
	$('#helpPollBtn').toggle(
		function(){ $('#helpBox').fadeIn(); },
		function(){ $('#helpBox').fadeOut(); }
	);
});