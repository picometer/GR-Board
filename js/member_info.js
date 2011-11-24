// 전역변수
var MY_NO;
var MOUSE_X_POS;
var MOUSE_Y_POS;

// xmlHttprqtuest 객체 할당
function getXmlHttpRequest()
{
	var rq = false;
	if (window.XMLHttpRequest) {
		rq = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		try {
			rq = new ActiveXObject('Msxml2.XMLHTTP');
		} catch (e1) {
			try {
				rq = new ActiveXObject('Microsoft.XMLHTTP');
			} catch (e2) {
				return false;
			}
		}
	}
	return rq;
}

// 출력을 위한 콜백
function callBackMeMember()
{
	if(rqt.readyState == 1) {
		showLoadingMember();
	} else if(rqt.readyState == 4) {
		if(rqt.status == 200) {
			showInfo();
		} else {
			alert('문제가 발생했습니다 : '+rqt.statusText);
		}
	}
}

// 로딩 시 보여주기
function showLoadingMember()
{
	var showBox = document.getElementById('viewMemberInfo');
	var result = '';
	showBox.style.display = '';
	showBox.innerHTML =  '<img src="image/admin/wait.gif" alt="" style="vertical-align: middle" /> 로딩중...';
}

// 멤버 이름 클릭시 시작
function getMember(no, myNo, e)
{
	var evt = e || window.event;
	var doc = document.documentElement;
	var bd = document.body;
	MOUSE_X_POS = evt.pageX || (evt.clientX + (bd.scrollLeft || doc.scrollLeft) - (doc.clientLeft || 0));
	MOUSE_Y_POS = evt.pageY || (evt.clientY + (bd.scrollTop || doc.scrollTop) - (doc.clientTop || 0));
	showBox = document.getElementById('viewMemberInfo');
	showBox.style.display = '';
	showBox.style.left = MOUSE_X_POS+'px';
	showBox.style.top = MOUSE_Y_POS+'px';
	if(no == '0') {
		showBox.innerHTML = '<div onmouseover="Over(this);" onmouseout="Out(this);">비회원임</div>';
		return;
	}
	if(myNo == '0') {
		MY_NO = '0';
		showBox.innerHTML = '<div onmouseover="Over(this);" onmouseout="Out(this);">로그인 하세요!</div>';
		return;
	}
	MY_NO = myNo;
	rqt = getXmlHttpRequest();
	rqt.onreadystatechange = callBackMeMember;
	rqt.open('POST', 'get_member_info.php', true);
	rqt.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	rqt.send('no='+no);
}

// 검색 결과를 보여주기
function showInfo()
{
	var showBox = document.getElementById('viewMemberInfo');
	var result = '';
	showBox.style.display = '';
	showBox.style.left = MOUSE_X_POS+'px';
	showBox.style.top = MOUSE_Y_POS+'px';
	showBox.innerHTML = '';
	var lists = rqt.responseXML.getElementsByTagName('lists')[0];
	var items = lists.getElementsByTagName('item');
	var boardID = document.forms['list'].elements['id'].value;
	for(i=0; i<items.length; i++) {
		var no = items[i].getAttribute('no');
		var email = items[i].getElementsByTagName('email')[0].firstChild.nodeValue;
		var homepage = items[i].getElementsByTagName('homepage')[0].firstChild.nodeValue;
		result += '<div onmouseover="Over(this);" onmouseout="Out(this);"><a href="'+GRBOARD+'board.php?id='+boardID+'&searchOption=member_key&searchText='+no+'" title="이 멤버가 쓴 글만 따로 정렬합니다."><img src="image/icon/sort_this_member.gif" alt="" /> 다른글 보기</a></div>';
		result += '<div onmouseover="Over(this);" onmouseout="Out(this);"><a href="#" onclick="window.open(\'send_memo.php?target='+no+'\', \'sendMemo\', \'width=650,height=600,menubar=no,scrollbars=yes\');"><img src="image/icon/send_memo_icon.gif" alt="" /> 쪽지 보내기</a></div>';
		result += '<div onmouseover="Over(this);" onmouseout="Out(this);"><a href="mailto:'+email+'"><img src="image/icon/send_email_icon.gif" alt="" /> 메일 보내기</a></div>';
		if(MY_NO == 1) {
			result += '<div onmouseover="Over(this);" onmouseout="Out(this);"><a href="#" onclick="window.open(\'get_member_article.php?user='+no+'\', \'getMemberArticle\', \'menubar=no,scrollbars=yes,resizable=yes,width=965,height=600\');"><img src="image/icon/article_trace_icon.gif" alt="" /> 게시글 추적</a></div>';
		}
		if(homepage != '0') result += '<div onmouseover="Over(this);" onmouseout="Out(this);"><a href="'+homepage+'" onclick="window.open(this.href, \'_blank\'); return false"><img src="image/icon/visit_homepage_icon.gif" alt="" /> 홈 페 이 지</a></div>';
		result += '<div onmouseover="Over(this);" onmouseout="Out(this);"><a href="#" onclick="window.open(\'member_info.php?memberKey='+no+'\', \'viewMemberInfo\', \'width=650,height=600,menubar=no,scrollbars=yes\');"><img src="image/icon/view_more_icon.gif" alt="" /> 회 원 정 보</a></div>';
	}
	showBox.innerHTML = result;
}

// 마우스 온 이벤트
function Over(t)
{
	t.style.backgroundColor='#ececec';
}

// 마우스 아웃 이벤트
function Out(t)
{
	t.style.backgroundColor='';
}

// 미니메뉴 마우스 아웃 이벤트
function showOff()
{
	tid = setTimeout('displayOff()', 8500);
}

// 아웃 이벤트 호출 시
function displayOff()
{
	document.getElementById('viewMemberInfo').style.display='none';
}
