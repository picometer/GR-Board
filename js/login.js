// 입력값 검사
function inputCheck() {
	var t = document.forms["boardLogin"];
	if(!t.elements["id"].value) {
		alert('아이디 를 입력해 주세요.');
		t.elements['id'].focus();
		return false;
	}	
	if(!t.elements["password"].value) {
		alert('비밀번호를 입력해 주세요.');
		t.elements['password'].focus();
		return false;
	}
	return true;
}

// 자동 로그인 확인 체크
function auto_ok(t) {
	if(t.checked) {
		if(!confirm('사용중이신 브라우저로 접속 시 자동 로그인 기능을 사용하시겠습니까?\n\n'+
			'PC방이나 공공장소에서 자동 로그인 기능을 사용 할 시 개인정보가 유출될 수 있습니다.\n\n'+
			'사용해제를 원하시면 브라우저의 쿠키(세션)를 비워주시면 됩니다.')) {
			t.checked = false;
		}
	}
}

// 마우스 오버시 버튼 그림변환
function btnOver(t) {
	t.src = str_replace('.gif', '_over.gif', t.src);
}

// 마우스 아웃시 버튼 그림변환
function btnOut(t) {
	t.src = str_replace('_over.gif', '.gif', t.src);
}

// 문자열 치환
function str_replace(str1, str2, str3) {
	var r = new RegExp(str1, 'g');
	return str3.replace(r, str2);
}
