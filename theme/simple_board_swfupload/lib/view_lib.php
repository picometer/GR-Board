<?php

// 첨부파일이 그림일 경우 처리하는 함수
function showImg($filename)
{
	global $id, $theme, $grboard, $articleNo, $dbFIX, $GR, $maxImageWidth;
	$getPdsSave = $GR->getArray('select no from '.$dbFIX.'pds_save where id = \''.$id.'\' and article_num = '.$articleNo.' limit 1');
	$getPdsList = $GR->getArray('select no, name from '.$dbFIX.'pds_list where type = 0 and uid = '.$getPdsSave['no'].' and idx = '.($fl-1));
	if($getPdsList['no']) $filename = end(explode('/', $getPdsList['name']));
	$ft = end(explode('.', $filename));
	$url = "data/$id/$filename";
	$realFileName = urldecode($filename);
	@$exifInfo = exif_read_data($url);
	if($exifInfo) {
			$replaceCode .= '<p class="exif">';
			if(isset($exifInfo['Model'])) $replaceCode .= $exifInfo['Model'];
			if(isset($exifInfo['ExposureProgram'])) {
				switch($exifInfo['ExposureProgram']) {
				case 1: $replaceCode .= ' | Manual'; break;
				case 2: $replaceCode .= ' | Normal program'; break;
				case 3: $replaceCode .= ' | Aperture priority'; break;
				case 4: $replaceCode .= ' | Shutter priority'; break;
				}
			}
			if(isset($exifInfo['ExposureTime'])) {
				$exposureTime = explode('/', $exifInfo['ExposureTime']);
				$replaceCode .= ' | '.$exposureTime[0] / $exposureTime[0].'/'.ceil($exposureTime[1] / $exposureTime[0]).'sec.';
			}
			if(isset($exifInfo['FNumber'])) {
				$fNumber = explode('/', $exifInfo['FNumber']);
				$replaceCode .= ' | F/'.$fNumber[0] / $fNumber[1];
			}
			if(isset($exifInfo['FocalLength'])) {
				$focalLength = explode('/', $exifInfo['FocalLength']);
				$replaceCode .= ' | '.round($focalLength[0] / $focalLength[1]).'mm';
			}
			if(isset($exifInfo['DateTimeOriginal'])) $replaceCode .= ' | '.$exifInfo['DateTimeOriginal'];
				$replaceCode .= '</p>';
		}
	if($ft == 'jpg') {
		return '<img src="'.$grboard.'/phpThumb/phpThumb.php?src=../data/'.$id.'/'.$filename.'&amp;w='.$maxImageWidth.'&amp;h=500&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="첨부파일 '.$realFileName.'" /></a>'.$replaceCode;
	}
	if($ft == 'gif' || $ft == 'png' || $ft == 'bmp') {
		return '<img src="'.$grboard.'/phpThumb/phpThumb.php?src=../data/'.$id.'/'.$filename.'&amp;w='.$maxImageWidth.'&amp;h=500&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="첨부파일 '.$realFileName.'" /></a>';
	}
	
}


function showText($filename)
{
	global $id, $theme, $grboard, $articleNo, $dbFIX, $GR;
	$getPdsSave = $GR->getArray('select no from '.$dbFIX.'pds_save where id = \''.$id.'\' and article_num = '.$articleNo.' limit 1');
	$getPdsList = $GR->getArray('select no, name from '.$dbFIX.'pds_list where type = 0 and uid = '.$getPdsSave['no'].' and idx = '.($fl-1));
	if($getPdsList['no']) $filename = end(explode('/', $getPdsList['name']));
	$ft = end(explode('.', $filename));
	$filename = urldecode($filename);
	return $filename;
}

// swfupload 적용 스킨에서 추가 업로드된 것 처리
function showDownImg($filename, $extNo)
{
	global $id, $theme, $grboard, $dbFIX, $GR;
	$getPdsList = $GR->getArray('select no, name from '.$dbFIX.'pds_list where type = 1 and uid = '.$extNo);
	if($getPdsList['no']) $filename = end(explode('/', $getPdsList['name']));
	$ft = end(explode('.', $filename));
	if($ft == 'jpg' || $ft == 'gif' || $ft == 'png' || $ft == 'bmp') {
		return '<li class="plusAdd"><span class="spIcon"></span><a href="data/'.$id.'/'.$filename.'" onclick="return hs.expand(this)">'.$filename.'</a></li>';
	}
	else return '<li class="plusAdd"><a href="'.$grboard.'/download.php?id='.$id.'&amp;articleNo='.$articleNo.'&amp;extNo='.$extNo.'" class="stringCut">'.$filename.'</a></li>';
}

// 게시물 날짜 구하기 @이동규
/** 
 * $t1 기준시간(없으면 현재시간으로 대체) 
 * $t2 비교시간 
 * by XEED(genesis@hotmail.co.kr) 
 * http://phpschool.com/gnuboard4/bbs/board.php?bo_table=tipntech&wr_id=72252
 */ 
function diffDate($sDate,$eDate)
{
	$date[0]=strtotime($sDate);
	$date[1]=strtotime($eDate);
	if($date[0] >= $date[1])
	{
		return false;
	}
	$date[2]=strtotime(date('Y-m-d  H:i:s',$date[1] - $date[0]));
	$Y=date('Y',$date[2])-1970;
	$m=date('n',$date[2])-1;
	$d=date('j',$date[2])-1;
	$H=intval(date('H',$date[2]))-9; //그리니치 표준시 우리나라일경우 -9
	$i=intval(date('i',$date[2]));
	$s=intval(date('s',$date[2]));
	if($H<0){ $H+=24; $d--; }
	if($Y)
	{ $returnDate= $Y; $returnDate.= '년 전'; }
	elseif($m)
	{ $returnDate= $m; $returnDate.= '달 전'; }
	elseif($d)
	{ $returnDate= $d; $returnDate.= '일 전'; }
	elseif($H)
	{ $returnDate= $H; $returnDate.= '시간 전'; }
	elseif($i)
	{ $returnDate.= '<span class="now">'. $i; $returnDate.= '분 전</span>'; }
	else { $returnDate.= '<span class="now">'. $s; $returnDate.= '초 전</span>'; }
	return $returnDate;
}

// 멤버일 경우 등록된 사진과 자기소개 출력
function showMemberInfo($mem=0)
{
	if(!$mem) return;
	global $dbFIX, $GR;
	$result = '<div id="viewMemInfo">';
	$m = $GR->getArray("select photo, self_info from {$dbFIX}member_list where no = '$mem'");
	if($m['photo']) $result .= '<div id="myPhoto"><img src="'.$m['photo'].'" alt="사진" title="" /></div>';
	else $result .= '<div id="myPhoto">&nbsp;</div>';
	if($m['self_info']) $result .= '<div id="myComment">'.stripslashes($m['self_info']).'</div>';
	else $result .= '<div id="myComment">소개글이 없습니다.</div>';
	$result .= '<div class="clear"></div></div>';
	return $result;
}

// 이름 출력 부분에 네임택이나 아이콘 출력 기능 추가
function showName($no, $name)
{
	$result = $name;
	global $dbFIX, $GR;
	$listtag = $GR->getArray("select nametag, icon from {$dbFIX}member_list where no = '".$no."'");
	if($listtag['nametag']) $result = '<img src="'.$listtag['nametag'].'" alt="" />';
	else $result = '<strong>'.$result.'</strong>';
	if($listtag['icon']) $result = '<img src="'.$listtag['icon'].'" alt="" /> '.$result;
	return $result;
}

// 지정된 너비 이상의 이미지는 본문 보기시 자동 리사이즈
function autoImgResize($maxWidth, $content)
{
	$content = str_replace(array('class="multi-preview" src="', '" alt="미리보기"'), array('class="multi-preview" src="phpThumb/phpThumb.php?src=../',
		'&amp;w='.$maxWidth.'&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="미리보기"'), $content);
	return $content;
}

// 추가 첨부된 파일 목록 출력
function showAddedFileList()
{
	global $dbFIX, $GR, $id, $articleNo;
	$extendLoop = 1;
	$getExtendFile = $GR->query('select no, file_route from '.$dbFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo);
	while($extendFile = $GR->fetch($getExtendFile)) { 
		$extendFileName = end(explode('/', $extendFile['file_route']));
		echo showDownImg($extendFileName, $extendFile['no']); 
		$extendLoop++; 
	}
}

// 댓글 보기 전 전처리
function setViewData($comment)
{
	// 내용이 없으면 종료
	if( !$comment ) return;
	
	global $GR, $dbFIX, $grboard;
	
	// 댓글이 블라인드 상태일 때
	if($comment['bad'] < -1000) {
		$blindMsg = '<div class="smallEng" title="댓글은 삭제되지 않았으나, 블라인드 해제가 되지 않으면 댓글 내용을 볼 수 없습니다.">'.
			'<strong>[!]</strong> 댓글이 관리자에 의해 블라인드 처리 되었습니다.'.(($isAdmin)?' (관리자는 댓글 내용이 보입니다.)':'').'</div>';
		if($isAdmin) $comment['content'] = $blindMsg.$comment['content'];
		else $comment['content'] = $blindMsg;
		$comment['subject'] = '── 관리자에 의해 블라인드 되었습니다 ──';
	}

	// 변수 처리
	$comment['name'] = stripslashes($comment['name']);
	$comment['subject'] = stripslashes($comment['subject']);
	$comment['content'] = stripslashes(nl2br($comment['content']));
	$comment['homepage'] = htmlspecialchars($comment['homepage']);
	$comment['email'] = htmlspecialchars($comment['email']);
	
	// 홈페이지
	if($comment['homepage']) $comment['homepage'] = '<a href="'.$comment['homepage'].'" class="commentBtn" title="'.$comment['name'].' 님의 홈으로 갑니다." onclick="window.open(this.href, \'_blank\'); return false;">[H]</a>';
	else $comment['homepage'] = "";
	
	// 이메일
	if($comment['email']) $comment['email'] = '<a href="mailto:'.$comment['email'].'" class="commentBtn" title="'.$comment['name'].' 님에게 메일을 보냅니다.">[E]</a>';
	else $comment['email'] = "";

	// 이름 대신 닉콘
	if($comment['member_key']) {
		$listtag = $GR->getArray("select nametag, icon from {$dbFIX}member_list where no = '".$comment['member_key']."'");
		if($listtag['nametag']) $comment['name'] = '<img src="'.$grboard.'/'.$listtag['nametag'].'" alt="'.$comment['name'].'" title="" /> ';
		if($listtag['icon']) $comment['name'] = '<img src="'.$grboard.'/'.$listtag['icon'].'" alt="" /> '.$comment['name'];
	}

	// 비밀 코멘트 시 처리
	if($comment['is_secret']) {
		if(!$_SESSION['no'] || ($comment['member_key'] != $_SESSION['no']) && ($view['member_key'] != $_SESSION['no']) && ($_SESSION['no'] != 1)) {
			$comment['subject'] = '비밀 댓글 입니다.';			
			$comment['content'] = '<span class="secretComment">비밀 댓글 입니다.</span>';
		}
	}
	return $comment;
}

// GR 코드 처리
	if($comment['is_grcode'])
	{
		$grcodeArr = array('[b]', '[/b]', '[i]', '[/i]', '[img]', '[/img]', '[big]', '[/big]', '[color:', ':]', '[/color]', '[code]', '[/code]', '[u]', '[/u]', '[s]', '[/s]', '[quote]', '[/quote]');
		$realtagArr = array('<strong>', '</strong>', '<em>', '</em>', '<img src="', '" alt="사용자 이미지" />', '<big>', '</big>', '<span style="color:', '">', '</span>', '<code>', '</code>', '<u>', '</u>', '<del>', '</del>', '<blockquote><div>', '</div></blockquote>');
		$content = str_replace($grcodeArr, $realtagArr, $content);
		$url_patterns = array("#\[url\]([\w]+?://([\w\#$%&~/.\-;:=,?@\]+]|\[(?!url=))*?)\[/url\]#is",
			"#\[url\](.([\w\#$%&~/.\-;:=,?@\]+]|\[(?!url=))*?)\[/url\]#is",
			"#\[url=([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is",
			"#\[url=([\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is");
		$url_replacements = array("<a href=\"\\1\">\\1</a>","<a href=\"http://\\1\">\\1</a>","<a href=\"\\1\">\\2</a>","<a href=\"http://\\1\">\\2</a>");
		$content = preg_replace($url_patterns, $url_replacements, $content);
	}

// 이모티콘 처리
	$emoticonCode = array(':?:', ':oops:', ':D', ':)', ':(', ':o', ':shock:', ':?', '8)', ':lol:', ':x', ':P', ':cry:', ':evil:', ':twisted:', ':roll:', ':wink:', ':!:', ':idea:', ':arrow:', ':|', ':mrgreen:');
	$emoticonImage = array('<img src="image/emoticon/icon_question.gif" alt="(물음표)" title="" />',
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
	'<img src="image/emoticon/icon_mrgreen.gif" alt="(초록 아저씨)" title="" />');
	$content = str_replace($emoticonCode, $emoticonImage, $content);
?>
