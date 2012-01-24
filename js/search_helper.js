// 검색어 입력이 시작될 때 호출
function startSearch(id) {
	var st = _('searchText').value; // _() 는 theme 안에 list.js 에 있음
	var so = _('searchOption').value;
	if(st) {
		var req = xmlHttp(); // member_info.js 가 먼저 호출되므로 거기서 빌려 옴
		req.onreadystatechange = function() {
			if(req.readyState == 4 && req.status == 200) {
				var lists = req.responseXML.getElementsByTagName('lists')[0];
				var t = document.getElementById('searchIndex');
				var result = '';
				t.style.display = '';
				t.innerHTML = '';
				var items = lists.getElementsByTagName('item');
				for(i=0; i<items.length; i++) {
					var no = items[i].getAttribute('no');
					var title = items[i].getElementsByTagName('title')[0].firstChild.nodeValue;
					title = htmlspecialchars(title);
					result += '<div><a href="'+GRBOARD+'board.php?id='+id+'&amp;articleNo='+no+'" title="보러가기">';
					result += title+'</a></div>';
				}
				result += '<div style="text-align:right"><a href="#" title="검색 도우미를 닫습니다." onclick="clearBox();">[닫기]</a></div>';
				t.innerHTML = result;
			}
		};
		req.open('POST', GRBOARD+'search_helper.php', true);
		req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		req.send('searchText='+st+'&searchOption='+so+'&boardID='+id);
	}
}

// 검색 결과값 처리
function htmlspecialchars(str) {
	var result = str.replace(/</g, '&lt;');
	result = result.replace(/>/g, '&gt;');
	return result;
}

// 추천 검색 박스 클리어
function clearBox() {
	_('searchIndex').style.display = 'none';
}