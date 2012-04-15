// 전역 사용
var EXTEND_PDS = 0;

// 게시물 작성완료되었을 때 값 체크
function checkWriteValue(isMember)
{
	t = document.forms["write"];
	try {
		var isOpenid = $('useOpenid').checked;
	} catch(e) { var isOpenid = false; }
	if(!isMember && !isOpenid)
	{
		if(!t.elements["name"].value)
		{
			alert('이름을 작성해주세요.');
			t.elements["name"].focus();
			return false;
		}
		if(!t.elements["password"].value)
		{
			alert('비밀번호를 작성해주세요.');
			t.elements["password"].focus();
			return false;
		}
		if(!t.elements["antispam"].value)
		{
			alert('자동등록방지용 답을 입력해 주세요. (숫자들의 계산값)');
			t.elements["antispam"].focus();
			return false;
		}
	}
	
	if(isOpenid && !t.elements['openid_url'].value) {
		alert('오픈아이디를 입력해 주세요.');
		t.elements['openid'].focus();
		return false;
	}
	
	if(!t.elements["subject"].value)
	{
		alert('게시물 제목을 입력해 주세요.');
		t.elements["subject"].focus();
		return false;
	}
	if(!USE_EDITOR && !t.elements["content"].value)
	{
		alert('게시물 내용을 입력해 주세요.');
		return false;
	}
	if(t.elements["is_timebomb"].checked && 
		(!t.elements["bombTime"].value || 
		t.elements["bombTime"].value < 1 ||
		t.elements["bombTime"].value > 1000000)) {
		alert('폭파될 시간값이 올바르지 않습니다. 숫자를 입력해 주세요.');
		return false;
	}

	return true;
}

// 게시물 작성취소
function isCancel(id)
{
	if(confirm('정말로 게시물 작성을 취소하시겠습니까?\n\n작성하신 글은 모두 사라집니다.'))
	{
		location.href='board.php?id='+id;
	}
}

// GR Code 클릭시 설명
function helpGrcode()
{
	alert('GR Code 란?\n\n'+
		'게시물 작성자가 HTML 태그대신 게시물에\n'+
		'각종 효과(색상주기, 글씨크기조정, 박스처리 등)를 주기 위해\n'+
		'사용가능한 축약된 태그입니다. 사용방법은 HTML 의 방식과 같습니다.\n'+
		'[태그]태그가적용될공간[/태그] 방식입니다.\n'+
		'참고 : GR Board 에서 HTML 태그 자체는 사용할 수 없습니다.\n\n'+
		'대표적으로 지원되는 GR Code 는 현재 아래와 같습니다.\n\n'+
		'[b]굵게할글자[/b] : 글자들이 굵게 됩니다.\n'+
		'[i]기울일글자[/i] : 글자들이 기울어집니다.\n'+
		'[img]http://그림주소[/img] : http:// 로 시작되는 그림주소가 있을 경우 그림이 표시됩니다.\n'+
		'[big]크게할글자[/big] : 글자들 크기가 커지게 됩니다.\n'+
		'[div]인용할문장[/div] : 문장 전체가 회색 박스 안으로 들어가게 됩니다.\n'+
		'[color:색상:]색상을 입힐 글자[/color] : 글자에 색상을 입힙니다.\n'+
		'예를 들어, \":색상:\" 을 \":red:\" 로 하면 붉은글씨가 됩니다.');
}

// 퀵태그 넣기
function quickTag(start, end)
{
	target = document.forms["write"].elements["content"];
	if(document.selection)
	{
		target.focus();
		ms = document.selection.createRange();

		if(ms.text.length > 0)
			ms.text = start + ms.text + end; 
		target.focus();
	}
	else 
	{
		target.value = target.value.substring(0, target.selectionStart)
			+ start + target.value.substring(target.selectionStart, target.selectionEnd)
			+ end + target.value.substring(target.selectionEnd, target.value.length);
		target.focus();
	}
}

// 토글 보이기
function showBtn(target)
{
	if($('#'+target).is(':hide'))
		$('#'+target).fadeIn();
	else
		$('#'+target).fadeOut();
}

// 이모티콘 삽입 (Emoticon by phpBB)
function emoticon(icon)
{
	document.forms["write"].elements["content"].value += icon;
}

// 폼 크기 조절
function formSize(n)
{
	t = document.forms["write"].elements["content"];
	if(n > 0) t.rows += n;
	else {
		if(t.rows > 4) t.rows += n;
		else alert('이미 최소 크기입니다. 더 이상 줄일 수 없습니다.');
	}
}

// 자동폭파 사용
function useBomb()
{
	t = document.forms["write"].elements["is_timebomb"];
	if(!confirm('정말로 이 게시물이 일정시간 후 자동 삭제되도록 하시겠습니까?\n\n'+
		'지정된 시간 이후에 게시물이 읽혀지면 게시물과 댓글, 첨부파일 등이 모두 삭제됩니다.\n\n'+
		'한 번 지정한 시간은 다시 수정되지 않으니 신중하게 설정해 주세요!')) {
		t.checked = false;
		return;
	} else t.checked = true;
	s = document.getElementById('setBomb');
	if(t.checked) s.style.display = '';
	else s.style.display = 'none';
}

// 경고문구 부착
function useAlert()
{
	t = document.forms["write"].elements["is_alert"];
	if(!confirm('정말로 이 게시물에 경고문구를 부착하시겠습니까?\n\n'+
		'읽는 이는 경고문구를 클릭한 후 게시물을 볼 수 있습니다.')) {
		t.checked = false;
	}
}

// 설문조사 사용 - 해제
function inputPoll(path, id)
{
	var l = parseInt((document.body.clientWidth / 2) - 250);
	window.open(path+'/poll.php?id='+id, 'poll', 'width=450,height=500,left='+l+',top=100,menubar=no,scrollbars=yes');
}

// 일반정보 or 오픈아이디
function setOpenid(s)
{
	if(s) {
		Effect.BlindDown('openidInput'); 
		Effect.BlindUp('normalInput');
		Effect.BlindUp('fileUploadField');
	} else {
		Effect.BlindDown('normalInput'); 
		Effect.BlindUp('openidInput');
		Effect.BlindDown('fileUploadField');
	}
}

// 문자열 치환
function str_replace(str1, str2, str3)
{
	var r = new RegExp(str1, 'g');
	return str3.replace(r, str2);
}

// HTML 관련 문자 변환
function htmlencode(str)
{
	str = str_replace('&', '@amp;', str);
	str = str_replace('\\+', '@plus;', str);
	str = str_replace('%', '@percent;', str);
	str = str_replace('#', '@sharp;', str);
	str = str_replace('\\?', '@question;', str);
	str = str_replace('\\=', '@equal;', str);
	return str;
}

// 주기적으로 DB서버에 글 내용을 저장
function autosave()
{
	tinyMCE.triggerSave();
	var t = document.forms['write'];
	var s = htmlencode(t.elements['subject'].value);
	var c = htmlencode(t.elements['content'].value);
	$('#writePreviewBox').fadeOut();

	if(s && c) {
		$.ajax({
			url: 'tmp_save.php',
			type: 'POST',
			data: 'subject='+s+'&content='+c,
			dataType: 'xml',
			success: function(xml) {
				$('#writePreviewBox').html('<img src="'+GRBOARD+'/image/admin/admin_db_backup.gif" alt="" style="vertical-align: middle" /> '+
					'글제목과 내용을 임시로 저장했습니다. [글 복구] 를 통해서 확인 가능합니다.').fadeIn();
			}
		});
	}
}

// 추가 업로드 필드
function moreUpload()
{
	EXTEND_PDS++;
	$('#extendUploads').html( $('#extendUploads').html() + '<div title="파일용량이 클 경우 한 번에 업로드가 되지 않을 수 있습니다.">추가파일 #'+
		EXTEND_PDS+': <input type="file" name="fileExtend'+EXTEND_PDS+'" class="input" /></div>' );
}

// 태그 선정 돕기
function tagAssist(tag, id)
{
	var lastTag = tag.split(',');
	var tag = lastTag[lastTag.length-1];

	$.ajax({
		url: 'tag_assist.php',
		type: 'POST',
		data: 'tag='+tag+'&id='+id,
		dataType: 'xml',
		success: function(xml) {
			var result = '<ol>';
			$(xml).find('lists').find('tags').each(function(index){				
				result += '<li title="태그 입력을 쉽게 하기 위해 이미 입력된 태그중 비슷한 걸 찾습니다."><strong>'+
					$(this).text()+'</strong> (사용된 횟수: '+$(this).attr('count')+'번)</li>';
			});
			result += '</ol>';
			$('#searchTags').fadeIn().html( result );
		}
	});
}

// 플래시 업로더용 스크립트 (by SWFUpload)
var swfu = new SWFUpload({ 
		post_params: {"PHPSESSID" : SESS_ID, "id" : BBS_ID},
		upload_url : GRBOARD+"/swfupload_ok.php", 
		flash_url : GRBOARD+"/swfupload.swf", 
		file_size_limit : "50 MB",
		file_types : "*.*",
		file_types_description : "All Files",
		file_upload_limit : 100,
		file_queue_limit : 0,
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		debug: false,
		button_placeholder_id: "swfUpBtnforGRBOARD",
		button_image_url: GRBOARD+"/"+THEME+"/image/swf.upload.btn.gif",
		button_width: "60",
		button_height: "20",
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete
});

// 페이지 로드 후 처리
$(function(){

	// 미니사전 보기 버튼 클릭시
	$('#miniDicBtn').click(function(){
		window.open('http://engdic.daum.net/dicen/small_top.do','DirectSearch_Dic','width=450,height=550,resizable=yes,scrollbars=yes');
	});

	// 글 복구 버튼 클릭시
	$('#recoveryPostBtn').click(function(){
		window.open('autosave.php', '_blank', 'width=550,height=650,menubar=no,scrollbars=yes'); 
		return false;
	});
});