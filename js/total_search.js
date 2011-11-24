var SEARCH_PATH;
var SEARCH_THEME;

// xmlHttpRequest 객체 할당
function getXHR()
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
function callBackMe()
{
	if(req.readyState == 1) {
		showLoading();
	} else if(req.readyState == 4) {
		if(req.status == 200) {
			showResult();
		} else {
			alert('문제가 발생했습니다 : '+req.statusText);
		}
	}
}

// 검색어 입력이 시작될 때 호출
function totalSearch(path, listNum, theme, type)
{
	SEARCH_PATH = path;
	SEARCH_THEME = theme;
	searchText = document.forms['grboardTotalSearch'].elements['searchText'].value;
	type = document.forms['grboardTotalSearch'].elements['type'].value;
	if(searchText.length) {
		req = getXHR();
		req.onreadystatechange = callBackMe;
		req.open('POST', path+'/total_search.php', true);
		req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		req.send('searchText='+searchText+'&listNum='+listNum+'&type='+type);
	}
}

// 검색 결과를 보여주기
function showResult()
{
	var lists = req.responseXML.getElementsByTagName('lists')[0];
	var showBox = document.getElementById('_latestSearchResult');
	var result = '';
	showBox.style.display = '';
	showBox.innerHTML = '';
	var items = lists.getElementsByTagName('item');
	for(i=0; i<items.length; i++) {
		var no = items[i].getAttribute('no');
		var searchText = items[i].getAttribute('searchText');
		var title = items[i].getElementsByTagName('title')[0].firstChild.nodeValue;
		var boardID = items[i].getElementsByTagName('boardID')[0].firstChild.nodeValue;
		title = htmlspecialchars(title);
		result += '<div class="latestSearchList">';
		if( boardID == '0' ) result += '<a href="#">';
		else result += '<a href="'+SEARCH_PATH+'/board.php?id='+boardID+'&amp;articleNo='+no+'" title="보러가기">';
		result += '<img src="'+SEARCH_PATH+'/latest/'+SEARCH_THEME+'/search_list_icon.gif" alt="" /> ';
		result += title+'</a></div>';
	}
	showBox.innerHTML = result;
}

// 로딩 시 보여주기
function showLoading()
{
	var showBox = document.getElementById('_latestSearchResult');
	var result = '';
	showBox.style.display = '';
	showBox.innerHTML = '<div id="_latestWaitSearch"><img src="'+SEARCH_PATH+'/latest/'+SEARCH_THEME+'/search_wait.gif" alt="" style="vertical-align: middle" /> 검색중 입니다...</div>';
	window.status = 'DB를 검색하고 있습니다...';
}

// 문자열 치환
function str_replace(str1, str2, str3)
{
	var r = new RegExp(str1, 'g');
	return str3.replace(r, str2);
}

// 검색 결과값 처리
function htmlspecialchars(str)
{
	result = str_replace('<', '&lt;', str);
	result = str_replace('>', '&gt;', result);
	return result;
}