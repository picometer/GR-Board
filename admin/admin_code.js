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

// 최근게시물 코드 생성하기
function createLatestCode()
{
	t = document.forms['codeLatest'];
	s = document.getElementById('latestPreviewCode');
	c = document.getElementById('insertCSS1');
	str = "&lt;?php latest('"+t.elements['latestTheme'].value+"', '"+t.elements['latestBoard'].value+"', '"+
		t.elements['latestNum'].value+"', '"+t.elements['latestCutNum'].value+"', '"+t.elements['latestGetContent'].value+
		"', '"+t.elements['latestCutContentNum'].value+"', '"+t.elements['latestDateForm'].value+"', '"+t.elements['latestSubject'].value+
		"', '"+t.elements['orderBy'].value+"', '"+t.elements['desc'].value+"'); ?&gt;";
	s.innerHTML = str;
	c.innerHTML = '@import url('+GRBOARD+'/latest/'+t.elements['latestTheme'].value+'/style.css);';
	return false;
}

// 내 알림 코드 생성하기
function createNotiCode()
{
	t = document.forms['codeNoti'];
	s = document.getElementById('notiPreviewCode');
	c = document.getElementById('insertCSS9');
	str = "&lt;?php noti('"+t.elements['notiTheme'].value+"', '"+t.elements['notiNum'].value+"', '"+t.elements['notiSubject'].value+"'); ?&gt;";
	s.innerHTML = str;
	c.innerHTML = '@import url('+GRBOARD+'/latest/'+t.elements['notiTheme'].value+'/style.css);';
	return false;
}

// 외부로그인 코드 생성하기
function createOutloginCode()
{
	t = document.forms['codeOutlogin'];
	s = document.getElementById('outloginPreviewCode');
	c = document.getElementById('insertCSS2');
	str = "&lt;?php outlogin('"+t.elements['outloginTheme'].value+"'); ?&gt;";
	s.innerHTML = str;
	c.innerHTML = '@import url('+GRBOARD+'/outlogin/'+t.elements['outloginTheme'].value+'/style.css);';
	return false;
}

// 통합 최근게시물 코드 생성하기
function createTotalLatestCode()
{
	t = document.forms['codeTotalLatest'];
	s = document.getElementById('latestTotalPreviewCode');
	c = document.getElementById('insertCSS3');
	str = "&lt;?php total_article_latest('"+t.elements['latestTotalTheme'].value+"', '"+t.elements['latestTotalNum'].value+
		"', '"+t.elements['latestTotalCutNum'].value+"', '"+t.elements['latestTotalDateForm'].value+
		"', '"+t.elements['latestTotalSubject'].value+"', "+t.elements['latestTotalGetSecret'].value+", '"+t.elements['orderBy'].value+"', '"+t.elements['desc'].value+"', '"+t.elements['boardList'].value+"'); ?&gt;";
	s.innerHTML = str;
	c.innerHTML = '@import url('+GRBOARD+'/latest/'+t.elements['latestTotalTheme'].value+'/style.css);';
	return false;
}

// 통합 최근코멘트 코드 생성하기
function createTotalCommentCode()
{
	t = document.forms['codeTotalComment'];
	s = document.getElementById('latestTotalCommentPreviewCode');
	c = document.getElementById('insertCSS4');
	str = "&lt;?php total_comment_latest('"+t.elements['latestTotalCommentTheme'].value+"', '"+t.elements['latestTotalCommentNum'].value+
		"', '"+t.elements['latestTotalCommentCutNum'].value+"', '"+t.elements['latestTotalCommentDateForm'].value+
		"', '"+t.elements['latestTotalCommentSubject'].value+"', "+t.elements['latestTotalCommentGetSecret'].value+", '"+
		t.elements['orderBy'].value+"', '"+t.elements['desc'].value+"', '"+t.elements['boardList'].value+"'); ?&gt;";
	c.innerHTML = '@import url('+GRBOARD+'/latest/'+t.elements['latestTotalCommentTheme'].value+'/style.css);';
	s.innerHTML = str;
	return false;
}

// 설문조사 코드 생성하기
function createPollCode()
{
	t = document.forms['codePoll'];
	s = document.getElementById('pollPreviewCode');
	c = document.getElementById('insertCSS5');
	str = "&lt;?php poll('"+t.elements['pollTheme'].value+"'); ?&gt;";
	c.innerHTML = '@import url('+GRBOARD+'/latest/'+t.elements['pollTheme'].value+'/style.css);';
	s.innerHTML = str;
	return false;
}

// 통합검색 코드 생성하기
function createTotalSearch()
{
	t = document.forms['codeTotalSearch'];
	s = document.getElementById('totalSearchPreviewCode');
	c = document.getElementById('insertCSS6');
	j = document.getElementById('insertJS');
	str = "&lt;?php total_search('"+t.elements['allSearchTheme'].value+"', "+t.elements['resultLimit'].value+"); ?&gt;";
	c.innerHTML = '@import url('+GRBOARD+'/latest/'+t.elements['allSearchTheme'].value+'/style.css);';
	s.innerHTML = str;
	j.innerHTML = '<span style="color: blue; cursor: help" title="통합검색을 추가할 경우, head~/head 사이에 이 스크립트를 넣어야 합니다.">&lt;script type="text/javascript" src="'+GRBOARD+'/js/total_search.js"&gt;&lt;/script&gt;</span>';
	return false;
}

// 통합 태그구름 코드 생성하기
function createTagCode()
{
	t = document.forms['codeTag'];
	s = document.getElementById('latestTagPreviewCode');
	c = document.getElementById('insertCSS7');
	str = "&lt;?php total_tag_latest('"+t.elements['tagTheme'].value+"', '"+t.elements['latestTagNum'].value+
		"', '"+t.elements['latestTagSubject'].value+"', '"+t.elements['orderBy'].value+"', '"+t.elements['desc'].value+"', '"+t.elements['boardList'].value+"'); ?&gt;";
	c.innerHTML = '@import url('+GRBOARD+'/latest/'+t.elements['tagTheme'].value+'/style.css);';
	s.innerHTML = str;
	return false;
}

// 현재 접속자 코드 생성하기
function createNowConnectCode()
{
	t = document.forms['nowConnect'];
	s = document.getElementById('latestNowConnectPreviewCode');
	c = document.getElementById('insertCSS8');
	str = "&lt;?php now_connect_list('"+t.elements['nowConnectTheme'].value+"', '"+t.elements['latestNowConnectNum'].value+
		"', '"+t.elements['latestNowConnectSubject'].value+"', '"+t.elements['orderBy'].value+"', '"+t.elements['desc'].value+"'); ?&gt;";
	c.innerHTML = '@import url('+GRBOARD+'/latest/'+t.elements['nowConnectTheme'].value+'/style.css);';
	s.innerHTML = str;
	return false;
}

// onsubmit 이벤트 잡아채기
document.forms['codeLatest'].onsubmit = createLatestCode;
document.forms['codeNoti'].onsubmit = createNotiCode;
document.forms['codeOutlogin'].onsubmit = createOutloginCode;
document.forms['codeTotalLatest'].onsubmit = createTotalLatestCode;
document.forms['codeTotalComment'].onsubmit = createTotalCommentCode;
document.forms['codePoll'].onsubmit = createPollCode;
document.forms['codeTotalSearch'].onsubmit = createTotalSearch;
document.forms['codeTag'].onsubmit = createTagCode;
document.forms['nowConnect'].onsubmit = createNowConnectCode;

// btnOver , btnOut 이벤트 잡아채기
var inputBtn = document.getElementsByTagName('input');
for(i=0; i<inputBtn.length; i++) {
	if(inputBtn[i].getAttribute('class') == 'btn') {
		inputBtn[i].onmouseover = function() { this.setAttribute('src', str_replace('.gif', '_over.gif', this.getAttribute('src'))); }
		inputBtn[i].onmouseout = function() { this.setAttribute('src', str_replace('_over.gif', '.gif', this.getAttribute('src'))); }
	}
}

// 페이지 로드 후 실행
$(function(){

	// 도움말 토글
	$('#helpCodeBtn').toggle(
		function(){ $('#helpBox').fadeIn(); },
		function(){ $('#helpBox').fadeOut(); }
	);
});