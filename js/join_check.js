// 아이디 중복 체크
function alreadyIdCheck() {
	var id = document.forms['join'].elements['id'].value;
	if(!id) alert('ID 값을 입력하세요');
	else window.open('id_check.php?id='+id, 'id_check', 'width=10,height=10,menubar=no,scrollbars=no');
}

// 닉네임 중복 체크
function alreadyNickCheck() {
	var nickname = document.forms['join'].elements['nickname'].value;
	if(!nickname) alert('닉네임을 입력하세요');
	else window.open('nick_check.php?nickname='+nickname, 'nick_check', 'width=10,height=10,menubar=no,scrollbars=no');
}

// 비밀번호 길이
function checkPassLength() {
	if(document.forms['join'].elements['password'].value.length < 4) {
		alert('비밀번호는 최소 4자 이상이어야 합니다.\n\n보안강화를 위해 반드시 4자 이상을 입력해 주세요.');
	}
}

// 폼 값 미리 체크
function isValueForm(f) {
    if(!f.elements['antiSpam'].value) {
		alert('자동등록방지 글자 4개를 입력해 주세요.');
		f.elements['antiSpam'].focus();
		return false;
	}
    if(!f.elements['id'].value) {
		alert('아이디 값을 입력해주세요. 아이디는 5자 이상, 45자 이하입니다.');
		f.elements['id'].focus();
		return false;
	}
	if(!f.elements['password'].value) {
		alert('비밀번호 값을 입력해주세요. 비밀번호는 6자 이상, 45자 이하입니다.');
		f.elements['password'].focus();
		return false;
	}
	if(!f.elements['passwordCheck'].value) {
		alert('비밀번호 확인 값을 입력해주세요. 비밀번호는 6자 이상, 45자 이하입니다.');
		f.elements['passwordCheck'].focus();
		return false;
	}
	if(!f.elements['nickname'].value) {
		alert('닉네임(별명)을 입력해주세요. 닉네임은 2자 이상, 18자 이하입니다.');
		f.elements['nickname'].focus();
		return false;
	}
	if(!f.elements['realname'].value) {
		alert('실명을 입력해주세요. 자신의 본명을 입력하셔야 합니다.');
		f.elements['realname'].focus();
		return false;
	}
	if(!f.elements['email'].value) {
		alert('전자우편(E-mail) 주소를 입력해 주세요. 비밀번호 찾기 시 필요합니다.');
		f.elements['email'].focus();
		return false;
	}
	if(f.elements['password'].value != f.elements['passwordCheck'].value) {
		alert('입력한 비밀번호와 확인 비밀번호가 다릅니다. 다시 확인해주세요.');
		f.elements['password'].focus();
		return false;
	}
    
    var patternId = /(^[a-zA-Z0-9\_]+$)/;

	// 패턴 검사
    if(!patternId.test(f.elements['id'].value)) { 
        wrestMsgId = f.elements['id'].value + ' : 영문, 숫자, _ 가 아닙니다. 올바른 아이디 형식이 아닙니다.\n'; 
        alert(wrestMsgId);
		f.elements['id'].focus();
		return false;
    }

	if(f.elements['enableJumin'].value == "1") {
		var juminPattern = /(^[0-9]+$)/;
		if(!juminPattern.test(f.elements['jumin'].value)) {
			alert('주민등록번호는 숫자로만 이루어져야 합니다.');
			f.elements['jumin'].focus();
			return false;
		}
	}
	return true;
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