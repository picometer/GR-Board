<script type="text/javascript" src="<?php echo $path; ?>/poll.js"></script>
<div id="pollBox">
<form id="vote" method="post" action="poll.php" onsubmit="return vote('<?php echo $grboard; ?>', <?php echo $pollNo; ?>);">
	<div id="pollSubject"><?php echo $subject; ?></div>
	<div id="pollOptions">
	<?php
	// 이 설문에 대한 항목을 차례대로 부름
	while($options = mysql_fetch_array($getOptions)) { ?>
		<div><input type="radio" name="pollOption" value="<?php echo $options['no']; ?>" /><?php echo stripslashes($options['title']); ?></div>
	<?php } ?>
	</div>
	<div id="pollButton">
		<input type="submit" value="투표" class="input" /> <input type="button" value="결과" class="input" onclick="window.open('<?php echo $grboard; ?>/poll/?p=<?php echo $pollNo; ?>', 'poll', 'width=550, height=600, menubar=no, scrollbars=yes'); return false" />
	</div>
</form>
</div>