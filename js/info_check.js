// 폼이 제대로 채워져 있는지 확인
function valueOk(f) {
	if(!f.elements['nickname'].value) {
		alert('사용하실 닉네임(별명)을 입력해 주세요.');
		f.elements['nickname'].focus();
		return false;
	}
	if(!f.elements['realname'].value) {
		alert('본인의 실명을 입력해 주세요.');
		f.elements['realname'].focus();
		return false;
	}
	if(!f.elements['email'].value) {
		alert('이메일을 입력해 주세요.');
		f.elements['email'].focus();
		return false;
	}
	if(f.elements['isEnableJumin'].value &&
		!f.elements['jumin'].value) {
		alert('주민등록번호를 하이픈(-) 없이 입력해주세요');
		f.elements['jumin'].focus();
		return false;
	}
	return true;
}

// 탈퇴하기
function outMe() {
	if(confirm('정말로 멤버에서 탈퇴하시겠습니까?\n\n'+
		'여태까지 쌓은 모든 정보를 잃게 됩니다.'))
	{
		location.href='info.php?outMe=1';
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

// 주민등록번호 입력폼 포커스시 체크
function isModify(t, f) {
	if(t.value) {
		if(confirm('이미 주민등록번호가 암호화되어 저장된 상태입니다.\n\n'+
		'이를 다시 변경하시겠습니까?')) {
			t.value = '';
		}
	}
}

// 닉네임 중복 체크
function alreadyNickCheck() {
	var nickname = document.forms['info'].elements['nickname'].value;
	if(!nickname) alert('닉네임을 입력하세요');
	else window.open('nick_check.php?nickname='+nickname, 'nick_check', 'width=10,height=10,menubar=no,scrollbars=no');
}