// 그룹 설정 변경
function modifyGroup(no)
{
	location.href='admin_group.php?modifyNo='+no;
}

// 멤버 그룹 설정 변경
function modifyMemberGroup(no)
{
	location.href='admin_member_group.php?modifyNo='+no;
}

// 그룹 삭제
function deleteGroup(no)
{
	if(no == 1) {
		alert('기본 그룹은 변경만 가능하며 삭제는 불가능 합니다.');
		return;
	}

	if(confirm('정말로 선택하신 그룹을 삭제하시겠습니까?\n\n'+
		'삭제하시게 되면 이 그룹에 속한 게시판들의 그룹은\n\n'+
		'기본 그룹으로 소속이 변경 됩니다.')) {
		location.href='admin_group.php?deleteNo='+no;
	}
}

// 멤버 그룹 삭제
function deleteMemberGroup(no)
{
	if(no == 1) {
		alert('기본 그룹은 변경만 가능하며 삭제는 불가능 합니다.');
		return;
	}

	if(confirm('정말로 선택하신 그룹을 삭제하시겠습니까?\n\n'+
		'삭제하시게 되면 이 그룹에 속한 멤버들의 그룹은\n\n'+
		'기본 그룹으로 소속이 변경 됩니다.')) {
		location.href='admin_member_group.php?deleteNo='+no;
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

// btnOver , btnOut 이벤트 잡아채기
var inputBtn = document.getElementsByTagName('input');
for(i=0; i<inputBtn.length; i++) {
	if(inputBtn[i].getAttribute('class') == 'btn') {
		inputBtn[i].onmouseover = function() { this.setAttribute('src', str_replace('.gif', '_over.gif', this.getAttribute('src'))); }
		inputBtn[i].onmouseout = function() { this.setAttribute('src', str_replace('_over.gif', '.gif', this.getAttribute('src'))); }
	}
}

// 클래스명이 popup 이면 새 창 띄우기
var newWindow = document.getElementsByTagName('a');
for(i=0; i<newWindow.length; i++) {
	if(newWindow[i].getAttribute('class') == 'popup') {
		newWindow[i].onclick = function() { window.open(this.getAttribute('href'), '_blank'); return false; }
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

// 메뉴 삭제하기
function deleteMenu(no)
{
	if(confirm('정말로 선택하신 항목을 삭제하시겠습니까?')) {
		location.href='admin_layout.php?deleteMenu='+no;
	}
}

// 페이지 제작용 에디터 부르기
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "table,save,advhr,advimage,advlink,insertdatetime,emotions,media,searchreplace,print,contextmenu,paste,directionality,fullscreen",
	theme_advanced_buttons1_add_before : "save,newdocument",
	theme_advanced_buttons1_add : "fontselect,fontsizeselect",
	theme_advanced_buttons2_add : "forecolor,backcolor,insertdate,inserttime",
	theme_advanced_buttons2_add_before: "cut,copy,paste,search,replace",
	theme_advanced_buttons3_add_before : "tablecontrols,preview",
	theme_advanced_buttons3_add : "emotions,media,advhr,print,fullscreen",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	content_css : "./theme/issac_board_in175/edit.css",
    plugi2n_insertdate_dateFormat : "%Y-%m-%d",
	plugi2n_insertdate_timeFormat : "%H:%M:%S",
	file_browser_callback : "fileBrowserCallBack",
	paste_use_dialog : false,
	theme_advanced_resizing : true,
	theme_advanced_resize_horizontal : false,
	theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
	paste_auto_cleanup_on_paste : true,
	paste_convert_headers_to_strong : false,
	paste_strip_class_attributes : "all",
	paste_remove_spans : false,
	paste_remove_styles : false	
});

function fileBrowserCallBack(field_name, url, type, win) {
	// This is where you insert your custom filebrowser logic
	//alert("Filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);

	// Insert new URL, this would normaly be done in a popup
	win.document.forms[0].elements[field_name].value = "localhost";
}

// 페이지 로드 후 실행
$(function(){

	// 도움말 토글
	$('#helpLayoutBtn').toggle(
		function(){ $('#helpBox').fadeIn(); },
		function(){ $('#helpBox').fadeOut(); }
	);
});