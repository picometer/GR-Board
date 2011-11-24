<form id="grboardTotalSearch" method="post" onsubmit="return false" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div class="latestTotalSearch">
	<select name="type">
		<option value="b">게시판</option>
		<option value="c">댓글</option>
	</select>
	<input type="text" class="i" onkeydown="totalSearch('<?php echo $grboard; ?>', <?php echo $listNum; ?>, '<?php echo $theme; ?>')" name="searchText" />
	<input type="image" src="<?php echo $path; ?>/search_now.gif" onclick="totalSearch('<?php echo $grboard; ?>', <?php echo $listNum; ?>, '<?php echo $theme; ?>')" alt="검색" />
</div>
</form>

<div id="_latestSearchResult"><div class="latestBeforeSearch">※ 검색어를 입력하시면, 이 곳에서 바로 결과를 확인하실 수 있습니다.</div></div>