<?php
// 콤보박스형태의 분류 목록 출력해주기
function showCategoryComboBox() 
{
	global $dbFIX, $id, $GR;
	$categories = $GR->getArray('select category from '.$dbFIX.'board_list where id = \''.$id.'\'');
	$categoryArray = @explode('|', $categories['category']);
	$countCategory = @count($categoryArray);
	for($ca=0; $ca<$countCategory; $ca++) {
		echo '<option value="'.urlencode($categoryArray[$ca]).'"'.
			(($categoryArray[$ca] == $clickCategory)?' selected="selected"':'').'>'.
			stripslashes($categoryArray[$ca]).'</option>';
	}
}

// 게시판 이름 가져오기 @이동규
$board_name = $GR->getArray('select name from '.$dbFIX.'board_list where id = \''.$id.'\'');

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

// 네임택 설정 @dragonkun, 및 공지 데이터 가공
function setNoticeData($notice)
{
	if(!$notice['no'] || !$notice['member_key']) {
		return;
	} else {
		global $dbFIX, $id, $GR, $cutingSubject;
		$noticeMemberKey = $notice['member_key'];
		$noticetag = $GR->getArray("select nametag, icon from {$dbFIX}member_list where no = '$noticeMemberKey'");
		if($noticetag['nametag']) $notice['name'] = '<img src="'.$noticetag['nametag'].'" alt="'.$notice['name'].'" />';
		if($noticetag['icon']) $notice['name'] = '<img src="'.$noticetag['icon'].'" alt="" /> '.$notice['name'];
	}
	$notice['subject'] = htmlspecialchars($GR->cutString(stripslashes($notice['subject']), $cutingSubject),ENT_COMPAT, 'UTF-8');
	return $notice;
}

// 일반 게시글 데이터 가공
function setArticleData($list)
{
	if(!$list['no']) return;
	global $dbFIX, $id, $GR, $cutingSubject, $searchText, $clickCategory, $grboard, $theme, $page;
	if($list['bad'] < -1000) $list['subject'] = $list['content'] = '── 관리자에 의해 블라인드 되었습니다 ──';
	if($list['member_key']) {
		$listtag = $GR->getArray("select nametag, icon from {$dbFIX}member_list where no = '".$list['member_key']."'");
		if($listtag['nametag']) $list['name'] = '<img src="'.$grboard.'/'.$listtag['nametag'].'" alt="'.$list['name'].'" title="" />';
		else $list['name'] = '<strong>'.$list['name'].'</strong>';
		if($listtag['icon']) $list['name'] = '<img src="'.$grboard.'/'.$listtag['icon'].'" alt="" /> '.$list['name'];
	}
	$list['subject'] = htmlspecialchars($GR->cutString(stripslashes($list['subject']), $cutingSubject),ENT_COMPAT, 'UTF-8'); 
	$list['link'] = $grboard.'/board.php?id='.$id.'&amp;articleNo='.(($list['board_no'])?$list['board_no']:$list['no']).'&amp;page='.$page.'&amp;searchText='.urlencode($searchText).'&amp;clickCategory='.$clickCategory;

	if($searchText) $list['subject'] = str_replace($searchText, '<span class="findMe">'.$searchText.'</span>', $list['subject']);

	if($list['is_secret']) $list['icon'] = '<img src="'.$grboard.'/'.$theme.'/image/secret.gif" alt="비밀" />';
	elseif(time() < $list['signdate']+86400) $list['icon'] = '<img src="'.$grboard.'/'.$theme.'/image/new.gif" alt="새글" />';
	else $list['icon'] = '<img src="'.$grboard.'/'.$theme.'/image/arrow.gif" alt="" />';
	return $list;
}
?>
