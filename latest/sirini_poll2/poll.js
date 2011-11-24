function vote(grboard, p)
{
	t = document.forms['vote'];
	var c = false;
	for (i=0; i<document.forms['vote'].length; i++) {
		if (document.forms['vote'][i].type == 'radio' && document.forms['vote'][i].checked) {
			c = document.forms['vote'][i].value;
			break;
		}
	}
	if (!c) {
		alert('항목을 선택해 주세요.');
		return false;
	}
	window.open(grboard+'/poll/?p='+p+'&addVote=1&addOption='+c, 'poll', 'width=550, height=600, menubar=no, scrollbars=yes');
	return false;
}