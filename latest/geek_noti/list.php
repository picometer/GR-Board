<div class="geekNotiParentBox">
	<?php
	// 게시물 루프
	$notiCount = 0;
	while($noti = $GR->fetch($getData))
	{
		if($noti['from_key']) $who = $GR->getArray("select nickname from {$dbFIX}member_list where no = " . $noti['from_key']);
		else $who['nickname'] = '비회원';
		$msg = '<strong>'.$who['nickname'].'</strong>님께서 ';
		switch($noti['act']) {
			case 0: // 쪽지 알림
				$msg = '<a href="'.$grboard.'/view_memo.php" onclick="window.open(this.href, \'_blank\', \'width=600,height=650,' . 
					'menubar=no,scrollbars=yes\'); return false" title="클릭하시면 쪽지함을 엽니다.">' . $msg . '회원님께 쪽지를 보냈습니다.</a>';
				break;
			case 1: // 내가 작성한 글에 댓글이 달림
				$msg = '<a href="'.$grboard.'/board.php?id='.$noti['bbs_id'].'&amp;articleNo='.$noti['bbs_no'].'" title="클릭하시면 해당 게시글을 확인하러 갑니다.">' . 
					$msg . '회원님이 작성하신 글에 댓글을 남겼습니다.</a>';
				break;
			case 2: // 내가 작성한 댓글에 댓글이 달림
				$msg = '<a href="'.$grboard.'/board.php?id='.$noti['bbs_id'].'&amp;articleNo='.$noti['bbs_no'].'" title="클릭하시면 해당 댓글을 확인하러 갑니다.">' . 
					$msg . '회원님이 작성하신 댓글에 대한 댓글을 남겼습니다.</a>';
				break;
			case 3: // 내가 작성한 글에 좋아요(GR보드용) 클릭함
				$msg = '<a href="'.$grboard.'/board.php?id='.$noti['bbs_id'].'&amp;articleNo='.$noti['bbs_no'].'" title="클릭하시면 글을 확인하러 갑니다.">' . 
					$msg . '회원님이 작성하신 글을 좋아합니다.</a>';
				break;
			case 4: // 내가 작성한 댓글에 좋아요(GR보드용) 클릭함
				$msg = '<a href="'.$grboard.'/board.php?id='.$noti['bbs_id'].'&amp;articleNo='.$noti['bbs_no'].'" title="클릭하시면 댓글을 확인하러 갑니다.">' . 
					$msg . '회원님이 작성하신 댓글을 좋아합니다.</a>';
				break;
		}	
		echo '<div class="geekNotiSubject">'.$msg.'</div>';
		$notiCount++;
	} # while
	
	// 만약 로그아웃 중이거나 알림사항이 하나도 없다면
	if(!$_SESSION['no'] || !$notiCount) {
		echo '<div class="geekNotiSubject">새로 알려드릴 소식이 아직 없습니다.</div>';
	}
	?>
	
</div>