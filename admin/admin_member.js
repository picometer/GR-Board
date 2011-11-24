// 검색할 멤버명을 입력했는지 확인하기
function isSearchValue()
{
	var f = document.forms["searchMember"];
	if(!f.elements["viewRows"].value)
	{
		alert('한페이지에 몇개씩 검색결과를 보실 것인지 숫자를 입력해주세요.');
		f.elements["viewRows"].focus();
		return false;
	}

	return true;
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

// 선택한 멤버를 정말로 삭제할 것인지 물어보기
function deleteMember(no, id)
{
	if(no == 1)
	{
		alert('관리자를 삭제할 수 없습니다.');
		return;
	}
	if(confirm('정말로 '+id+' 님을 삭제하시겠습니까?\n\n'+
		'삭제된 멤버도 다시 재가입을 통해서 멤버가 될 수 있습니다.\n\n'+
		'삭제하시겠습니까?'))
	{
		location.href='admin_member.php?deleteMemberNo='+no+'&deleteMemberId='+id;
	}
}

// 수정한 멤버정보 중 필수정보가 비었는지 검사
function isModifyValue()
{
	var f = document.forms["modifyMember"];
	if(!f.elements["modifyNickname"].value)
	{
		alert('닉네임(별명)을 입력해주세요.');
		f.elements["modifyNickname"].focus();
		return false;
	}

	if(!f.elements["modifyRealname"].value)
	{
		alert('이름(실명)을 입력해주세요.');
		f.elements["modifyRealname"].focus();
		return false;
	}
}

// 멤버 추가시 필수정보 검사
function isAddValue()
{
	var f = document.forms["addMember"];
	if(!f.elements["addID"].value)
	{
		alert('멤버 ID를 입력해주세요.');
		f.elements["addID"].focus();
		return false;
	}

	if(!f.elements["addNickname"].value)
	{
		alert('닉네임(별명)을 입력해주세요.');
		f.elements["addNickname"].focus();
		return false;
	}

	if(!f.elements["addRealname"].value)
	{
		alert('이름(실명)을 입력해주세요.');
		f.elements["addRealname"].focus();
		return false;
	}

	if(!f.elements["addPassword"].value)
	{
		alert('비밀번호를 입력해주세요.');
		f.elements["addPassword"].focus();
		return false;
	}
}

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

// 아이디 중복 체크
function alreadyIdCheck()
{
	var f = document.forms["addMember"];
	if(!f.elements["addID"].value)
	{
		alert('ID 값을 입력하세요');
	} 
	else
	{
		window.open("id_check.php?id="+f.elements["addID"].value, "id_check", "width=10,height=10,menubar=no,scrollbars=no");
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

// 마우스 오버시 버튼 그림변환
function btnOver(t)
{
	t.src = str_replace('.gif', '_over.gif', t.src);
}

// 마우스 아웃시 버튼 그림변환
function btnOut(t)
{
	t.src = str_replace('_over.gif', '.gif', t.src);
}

// 문자열 치환
function str_replace(str1, str2, str3)
{
	var r = new RegExp(str1, 'g');
	return str3.replace(r, str2);
}

// 도움말 토글
function toggleHelp(id)
{
	t = document.getElementById(id);
	if(t.style.display == '') Effect.Fade(id);
	else Effect.Appear(id);
}

// 전체선택버튼
function selectAll()
{
	var j;
	var f = document.forms['searchMember'];
	for(j=0; j<f.length; j++)
	{
		if(f[j].type=='checkbox')
		{
			f[j].checked = !f[j].checked;
		}
	}
}

// 선택된 멤버 삭제
function deleteCheckMember()
{
	var j;
	var str = '';
	var flag = false;
	var f = document.forms['searchMember'];
	for(j=0; j<f.length; j++)
	{
		if(f[j].type=='checkbox' && f[j].checked)
		{
			str += '&dcm[]='+f[j].value;
			flag = true;
		}
	}
	if(flag) {
		if(confirm('정말로 선택된 멤버들을 삭제하시겠습니까?')) 
			location.href = 'admin_member.php?x=y'+str;
	} else alert('멤버들을 선택해 주세요.');
}

// 선택된 멤버들의 레벨변경
function changeLevel(n)
{
	var j;
	var str = '';
	var flag = false;
	var f = document.forms['searchMember'];
	for(j=0; j<f.length; j++)
	{
		if(f[j].type=='checkbox' && f[j].checked)
		{
			str += '&clm[]='+f[j].value;
			flag = true;
		}
	}
	if(flag) {
		if(confirm('정말로 선택된 멤버들의 레벨을 '+n+' 로 변경하시겠습니까?')) {
			location.href = 'admin_member.php?changeLevel='+n+str;
		}
	} else alert('멤버들을 선택해 주세요.');
}

// 페이지 로드 후 실행
$(function(){

	// 도움말 토글
	$('#helpMemberBtn').toggle(
		function(){ $('#helpBox').fadeIn(); },
		function(){ $('#helpBox').fadeOut(); }
	);
});