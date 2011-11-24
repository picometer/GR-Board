// 글 미리보기
function preview()
{
	prevBox = document.getElementById('writePreviewBox');
	t = document.forms['write'];
	if(!t.elements['content'].value) {
		alert('글 내용을 작성해 주세요');
		t.elements['content'].focus();
		return;
	}

	if(prevBox.style.display == 'none') {
		prevBox.style.display = '';
	} else {
		prevBox.style.display = 'none';
		return;
	}

	content = htmlspecialchars(t.elements['content'].value);
	content = str_replace("\n", '<br />', content);

	grcode = ['[b]', '[/b]', '[i]', '[/i]', '[img]', '[/img]', '[big]', '[/big]', '[color:', ':]', '[/color]', '[div]', '[/div]', '[u]', '[/u]', '[s]', '[/s]', '[quote]', '[/quote]',
		'[url]', '[/url]'];
	htmlcode = ['<strong>', '</strong>', '<em>', '</em>', '<img src="', '" alt="image" />', '<big>', '</big>', '<span style="color:', '">', '</span>', 
		'<div class="grcodeDIV">', '</div>', '<u>', '</u>', '<del>', '</del>', '<blockquote><div>', '</div></blockquote>',
		'<span style="cursor: help;" title="링크는 글 작성 완료 후 확인해 보세요. 정상적으로 출력됩니다.">', '</span>'];

	if(t.elements['is_grcode'].value) {
		for(i=0; i<21; i++) {
			while(content.indexOf(grcode[i]) != -1) {
				content = content.replace(grcode[i], htmlcode[i]);
			}
		}
	}

	emoticon = [':?:', ':oops:', ':D', ':)', ':(', ':o', ':shock:', ':?', '8)', ':lol:', ':x', ':P', ':cry:', ':evil:', ':twisted:', ':roll:', ':wink:', ':!:', ':idea:', ':arrow:', ':|', ':mrgreen:'];
	emoToImg = ['<img src="image/emoticon/icon_question.gif" alt="(물음표)" title="" />',
	'<img src="image/emoticon/icon_redface.gif" alt="(당황)" title="" />',
	'<img src="image/emoticon/icon_biggrin.gif" alt="행복해" title="행복해" />', 
	'<img src="image/emoticon/icon_smile.gif" alt="(미소)" title="" />', 
	'<img src="image/emoticon/icon_sad.gif" alt="(슬퍼요)" title="" />',
	'<img src="image/emoticon/icon_surprised.gif" alt="(놀람)" title="" />',
	'<img src="image/emoticon/icon_eek.gif" alt="(쇼크)" title="" />',
	'<img src="image/emoticon/icon_confused.gif" alt="(혼란)" title="" />',
	'<img src="image/emoticon/icon_cool.gif" alt="(시원함)" title="" />',
	'<img src="image/emoticon/icon_lol.gif" alt="(웃음)" title="" />',
	'<img src="image/emoticon/icon_mad.gif" alt="(미친)" title="" />',
	'<img src="image/emoticon/icon_razz.gif" alt="(냉소)" title="" />',
	'<img src="image/emoticon/icon_cry.gif" alt="(울음)" title="" />',
	'<img src="image/emoticon/icon_evil.gif" alt="(사악함)" title="" />',
	'<img src="image/emoticon/icon_twisted.gif" alt="(비틀어진 사악함)" title="" />',
	'<img src="image/emoticon/icon_rolleyes.gif" alt="(눈굴림)" title="" />',
	'<img src="image/emoticon/icon_wink.gif" alt="(윙크)" title="" />',
	'<img src="image/emoticon/icon_exclaim.gif" alt="(느낌표)" title="" />',
	'<img src="image/emoticon/icon_idea.gif" alt="(아이디어)" title="" />',
	'<img src="image/emoticon/icon_arrow.gif" alt="(화살표)" title="" />',
	'<img src="image/emoticon/icon_neutral.gif" alt="(무표정)" title="" />',
	'<img src="image/emoticon/icon_mrgreen.gif" alt="(초록 아저씨)" title="" />'];

	for(i=0; i<22; i++) {
		while(content.indexOf(emoticon[i]) != -1) {
			content = content.replace(emoticon[i], emoToImg[i]);
		}
	}

	prevBox.innerHTML = content;
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