// 코멘트 입력값 확인
function valueCheck(isMember)
{
	clearPos();
	t = document.forms["commentWrite"];
	if(!isMember && !t.elements['openid_url'].value) 
	{
		if(!t.elements['name'].value) {
			alert('이름을 입력해 주세요.');
			t.elements["name"].focus();
			return false;
		}
		if(!t.elements['password'].value)	{
			alert('비밀번호를 입력해 주세요.');
			t.elements['password'].focus();
			return false;
		}
		if(!t.elements['antispam'].value)	{
			alert('자동등록방지용 답을 입력해 주세요. (숫자들의 계산값)');
			t.elements['antispam'].focus();
			return false;
		}
	}
	if(!USE_CO_EDITOR && !t.elements["content"].value) {
		alert('내용을 입력해 주세요.');
		t.elements["content"].focus();
		return false;
	}
	return true;
}

// GR Code 클릭시 설명
function helpGrcode()
{
	alert('GR Code 란?\n\n'+
		'게시물 작성자가 HTML 태그대신 게시물에 각종 효과(색상주기, 글씨크기조정, 박스처리 등)를 주기 위해\n'+
		'사용가능한 축약된 태그입니다. 사용방법은 HTML 의 방식과 같습니다. [태그]태그가적용될공간[/태그] 방식입니다.\n'+
		'참고 : GR Board 에서 코멘트 입력시 HTML 태그 자체는 사용할 수 없습니다.\n\n'+
		'대표적으로 지원되는 GR Code 는 현재 아래와 같습니다.\n\n'+
		'[b]굵게할글자[/b] : 글자들이 굵게 됩니다.\n'+
		'[i]기울일글자[/i] : 글자들이 기울어집니다.\n'+
		'[img]http://그림주소[/img] : http:// 로 시작되는 그림주소가 있을 경우 그림이 표시됩니다.\n'+
		'[big]크게할글자[/big] : 글자들 크기가 커지게 됩니다.\n'+
		'[div]인용할문장[/div] : 문장 전체가 회색 박스 안으로 들어가게 됩니다.\n'+
		'[color:색상:]색상을 입힐 글자[/color] : 글자에 색상을 입힙니다. 예를 들어, \":색상:\" 을 \":red:\" 로 하면 붉은글씨가 됩니다.');
}
// 글 삭제 묻기
function deleteArticleOk(id, articleNo)
{
	if(confirm('정말로 이 게시물을 삭제하시겠습니까?'))
	{
		location.href='delete.php?id='+id+'&articleNo='+articleNo+'&targetTable=bbs&readyWork=delete';
	}
}

// 트랙백 주소 복사
function clickToCopy(str) 
{
	prompt("이 글의 고유주소입니다. Ctrl+C를 눌러 복사하세요.", str);
}

// 퀵태그 넣기
function quickTag(start, end)
{
	target = document.forms["commentWrite"].elements["content"];
	// 익스플로러
	if(document.selection) {
		target.focus();
		ms = document.selection.createRange();

		if(ms.text.length > 0)
			ms.text = start + ms.text + end; 
		target.focus();
	}
	// 모질라
	else {
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
	document.forms["commentWrite"].elements["content"].value += icon;
}

// 코멘트 삭제할 것인지 물어보기
function commentDeleteOk(id, no, cNo, page)
{
	if(confirm('이 코멘트를 정말로 삭제하시겠습니까?'))
	{
		location.href='delete.php?id='+id+'&articleNo='+no+'&commentNo='+cNo+'&targetTable=comment&readyWork=c_delete&page='+page;
	}
}

// 폼 크기 조절
function formSize(n)
{
	t = document.forms["commentWrite"].elements["content"];
	if(n > 0) t.rows += n;
	else {
		if(t.rows > 4) t.rows += n;
		else alert('이미 최소 크기입니다. 더 이상 줄일 수 없습니다.');
	}
}

// 코멘트 작성폼 위치 지정/해제 (자바스크립트 쿠키 사용)
function setCookie(name, value, expiredays)
{
	var todayDate = new Date();
	todayDate.setDate(todayDate.getDate() + expiredays);
	document.cookie = name + "=" + escape(value) + ";path=/;expires=" + todayDate.toGMTString() + ";"
}
function setPos(e)
{
	if(!e) e = window.event;
	var t = $('layerCoWrite');
	var posX = Event.pointerX(e);
	var posY = Event.pointerY(e);
	setCookie('pointer[0]', posX, 86400);
	setCookie('pointer[1]', posY, 86400);
	t.style.left = posX + 'px';
	t.style.top = posY + 'px';
}
function clearPos()
{
	setCookie('pointer[0]', '');
	setCookie('pointer[1]', '');
}

// 경고문구 부착된 게시물 읽기
function readAlert()
{
	var s = document.getElementById('hideContent');
	if(s.style.display == 'none') Effect.Appear('hideContent');
	else Effect.Fade('hideContent');
}

// 설문참여
function insertVote()
{
	var choice = document.forms['livePoll'].elements['choice'];
	for(i=0; i<choice.length; i++) {
		if(choice[i].checked == true) var targetNo = choice[i].value;
	}

	$.ajax({
		type: 'POST',
		url: 'poll/insert_board_poll.php',
		data: 'targetNo='+targetNo,
		dataType: 'xml',
		success: function(xml) {
			alert( $(xml).find('msg').text() );
		}
	});

	return false;
}

// 설문조사 출력
if($('#pollBox').attr('id') == 'pollBox') {

	$('#pollBox').hide();
	$.ajax({
		type: 'POST',
		url: 'poll/get_board_poll.php',
		data: 'getNo='+$('#pollBox').attr('alt'),
		dataType: 'xml',
		success: function(xml) {
			var subject = $(xml).find('lists').find('subject').text();
			var result = '<div id="getPollBox"><form id="livePoll" method="post" action="./" onsubmit="return insertVote();">'+
				'<div id="insidePoll"><div class="title">[설문조사] '+subject+'</div><ol class="options">';
			$(xml).find('lists').find('option').each(function(i) {
				result += '<li><input type="radio" id="choice'+i+'" name="choice" value="'+$(this).attr('no')+'" /> '+
					'<label for="choice'+i+'">'+$(this).text()+'</label></li>';
			});
			result += '</ol><input type="submit" value="투표하기" class="s" /> <input type="button" value="결과보기" '+
				'onclick="window.open(\'poll/?p='+$('#pollBox').attr('alt')+'\', \'showPoll\', \'width=550, height=600, '+
				'menubar=no, scrollbars=yes\');" class="s" /></div></form></div>';
			$('#mainContent').append(result);
		}
	});
}

// 게시물 블라인드 치기
function blindArticleOk(id, no, type, modifyTarget)
{
	if(type == 'bbs_') var target = '게시물'; else var target = '댓글';
	if(confirm('이 '+target+'을 블라인드 처리 하시겠습니까?\n\n'+target+'은 삭제되지 않으나 '+target+' 내용은 관리자를 제외하고는\n\n누구도 볼 수 없습니다.')) {
		location.href='board.php?id='+id+'&articleNo='+no+'&blind=on&blindTarget='+modifyTarget+'&tableType='+type;
	}
}

// 게시물 블라인드 해제
function blindArticleNo(id, no, type, modifyTarget)
{
	if(type == 'bbs_') var target = '게시물'; else var target = '댓글';
	if(confirm('이 '+target+'에 적용된 블라인드 처리를 해제하시겠습니까?\n\n가려졌던 '+target+' 내용이 다시 원래대로 누구에게나 보여집니다.')) {
		location.href='board.php?id='+id+'&articleNo='+no+'&blind=off&blindTarget='+modifyTarget+'&tableType='+type;
	}
}

// 동영상 플레이어 치환 처리
if(document.getElementById('player-box-1') != undefined) {
	for(p=1; p<10; p++) {
		if(document.getElementById('player-box-'+p) != undefined) {
			var player = document.getElementById('player-box-'+p);
			player.style.display = 'none';
			var filename = player.className;
			var playerDIV = document.createElement('div');
			playerDIV.id = 'player'+p;
			playerDIV.innerHTML = "<div id='preview-"+p+"'></div>";
			$('#player-layout').append(playerDIV);
			var s = new SWFObject('player.swf','ply'+p,'470','320','9','#ffffff');
			s.addParam('allowfullscreen','true'); 
			s.addParam('allowscriptaccess','always'); 
			s.addParam('wmode','opaque'); 
			s.addParam('flashvars','file=data/'+BBS_ID+'/'+filename); 
			s.write('preview-'+p);
		} else break;
	}
}

// highslide JS
try {
	hs.graphicsDir = 'image/graphics/';
	hs.creditsText = '';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.numberPosition = 'caption';
	hs.dimmingOpacity = 0.75;
		
	// Add the controlbar
	if (hs.addSlideshow) hs.addSlideshow({
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: true,
		overlayOptions: {
			opacity: .75,
			position: 'top center',
			hideOnMouseOut: true
		}
	});

	// 스타일을 동적으로 할당
	var hi = document.createElement('link');
	hi.setAttribute('rel', 'stylesheet');
	hi.setAttribute('href', 'highslide.css');
	hi.setAttribute('type', 'text/css');
	hi.setAttribute('title', 'style');
	document.documentElement.getElementsByTagName("HEAD")[0].appendChild(hi);
} catch(e) {}