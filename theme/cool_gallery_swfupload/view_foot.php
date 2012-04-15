<?php if(!defined('__GRBOARD__')) exit(); ?>

<?php if($printPage): ?><div class="comment_paging"><?php echo $printPage; ?></div><?php endif; ?>

<div class="menuBox">
	
	<a href="<?php echo $grboard; ?>/write.php?id=<?php echo $id; ?>&amp;clickCategory=<?php echo $clickCategory; ?>" title="글을 작성합니다">새글작성</a>
	
	<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;page=<?php echo $page; ?>&amp;searchOption=<?php echo $searchOption; ?>&amp;searchText=<?php echo urlencode($searchText); ?>&amp;clickCategory=<?php echo $clickCategory; ?>" title="목록을 봅니다">목록보기</a>
	
	<a href="<?php echo $grboard; ?>/write.php?id=<?php echo $id; ?>&amp;mode=modify&amp;articleNo=<?php echo $articleNo; ?>&amp;page=<?php echo $page; ?>&amp;clickCategory=<?php echo $clickCategory; ?>" title="글을 수정합니다">수정하기</a>
	
	<a href="#" onclick="deleteArticleOk('<?php echo $id.'\', '.$articleNo; ?>);" title="이 게시물을 삭제합니다.">삭제하기</a>
	
	<?php if($isAdmin && ($view['bad'] > -1000)): ?>
		<a href="#" onclick="blindArticleOk('<?php echo $id.'\', '.$articleNo; ?>, 'bbs_', <?php echo $articleNo; ?>);" title="이 게시물을 블라인드 처리 합니다. (삭제하지는 않고, 게시물 내용만 확인이 안됩니다.)">블라인드 하기</a>
	<?php endif; ?>
	
	<?php if($isAdmin && ($view['bad'] < -1000)): ?>
	<a href="#" onclick="blindArticleNo('<?php echo $id.'\', '.$articleNo; ?>, 'bbs_', <?php echo $articleNo; ?>);" title="이 게시물의 블라인드 처리를 해제합니다. (가려졌던 게시물 내용이 다시 보입니다.)">블라인드 해제</a>
	<?php endif; ?>

</div>

<?php if(!$isViewList): ?>
	</div>
	<form id="list" action="/" method="post"><input type="hidden" id="id" value="<?php echo $id; ?>" /></form>
	<div id="viewMemberInfo" style="display: none" onmouseout="showOff();"></div>
<?php endif; ?>

<script>
var GRBOARD = '<?php echo $grboard; ?>/';
var USE_CO_EDITOR = <?php if($tmpFetchBoard['is_comment_editor']) { ?>true<?php } else { ?>false<?php } ?>;
</script>
<script src="<?php echo $grboard; ?>/js/highslide-full.packed.js"></script>
<script src="<?php echo $grboard; ?>/js/jquery.js"></script>
<script src="<?php echo $grboard; ?>/js/swfobject.js"></script>
<script src="<?php echo $grboard.'/'.$theme; ?>/view.js"></script>
<script src="<?php echo $grboard; ?>/js/member_info.js"></script>