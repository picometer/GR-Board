// 쪽지 보내기 값 체크
function checkMemo()
{
	if(!document.forms["sendMemo"].elements["subject"].value)
	{
		alert('제목을 입력해 주세요.');
		document.forms["sendMemo"].elements["subject"].focus();
		return false;
	}

	if(!document.forms["sendMemo"].elements["content"].value)
	{
		alert('내용을 입력해 주세요.');
		document.forms["sendMemo"].elements["content"].focus();
		return false;
	}

	return true;
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