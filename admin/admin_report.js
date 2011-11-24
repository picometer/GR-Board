// 신고된 게시물 삭제시
function deletePost(id, no, uid) {
	if(confirm('정말로 이 게시물을 삭제하시겠습니까?\n\n삭제하시기 전에 한 번 더 게시물을 검토해보세요.\n\n지금 게시물을 삭제하시겠습니까?')) {
		window.open('delete.php?id='+id+'&articleNo='+no+'&targetTable=bbs&isReported='+uid, '_blank', 'width=10,height=10,menubar=no');
		return false;
	}
}

// 페이지 로드 후 실행
$(function(){

	// 도움말 토글
	$('#helpReportBtn').toggle(
		function(){ $('#helpBox').fadeIn(); },
		function(){ $('#helpBox').fadeOut(); }
	);
});