<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{#emotions_dlg.title}</title>
	<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script type="text/javascript" src="js/emotions.js"></script>
	<base target="_self" />
<style type="text/css">/*<![CDATA[*/
body, td {
	font-family: Dotum, 돋움, sans-serif;
	font-size: 11px;
	text-align: center;
}
table {
	width: 100%;
}
th {
	height: 25px;
	border: #ddd 1px solid;
	background-color: #fafafa;
}
/*]]>*/</style>
</head>
<body>
		<div class="title">{#emotions_dlg.title}:<br /><br /></div>

		<table border="0" cellspacing="0" cellpadding="4">
		<thead>
		<tr>
			<th colspan="8">기본 이모티콘</th>
		</tr>
		</thead>
		<tbody>
		  <tr>
			<td><a href="javascript:EmotionsDialog.insert('smiley-cool.gif','emotions_dlg.cool');"><img src="img/smiley-cool.gif" width="18" height="18" border="0" alt="{#emotions_dlg.cool}" title="{#emotions_dlg.cool}" /></a></td>
			<td><a href="javascript:EmotionsDialog.insert('smiley-cry.gif','emotions_dlg.cry');"><img src="img/smiley-cry.gif" width="18" height="18" border="0" alt="{#emotions_dlg.cry}" title="{#emotions_dlg.cry}" /></a></td>
			<td><a href="javascript:EmotionsDialog.insert('smiley-embarassed.gif','emotions_dlg.embarassed');"><img src="img/smiley-embarassed.gif" width="18" height="18" border="0" alt="{#emotions_dlg.embarassed}" title="{#emotions_dlg.embarassed}" /></a></td>
			<td><a href="javascript:EmotionsDialog.insert('smiley-foot-in-mouth.gif','emotions_dlg.foot_in_mouth');"><img src="img/smiley-foot-in-mouth.gif" width="18" height="18" border="0" alt="{#emotions_dlg.foot_in_mouth}" title="{#emotions_dlg.foot_in_mouth}" /></a></td>
			<td><a href="javascript:EmotionsDialog.insert('smiley-frown.gif','emotions_dlg.frown');"><img src="img/smiley-frown.gif" width="18" height="18" border="0" alt="{#emotions_dlg.frown}" title="{#emotions_dlg.frown}" /></a></td>
			<td><a href="javascript:EmotionsDialog.insert('smiley-innocent.gif','emotions_dlg.innocent');"><img src="img/smiley-innocent.gif" width="18" height="18" border="0" alt="{#emotions_dlg.innocent}" title="{#emotions_dlg.innocent}" /></a></td>
			<td><a href="javascript:EmotionsDialog.insert('smiley-kiss.gif','emotions_dlg.kiss');"><img src="img/smiley-kiss.gif" width="18" height="18" border="0" alt="{#emotions_dlg.kiss}" title="{#emotions_dlg.kiss}" /></a></td>
			<td><a href="javascript:EmotionsDialog.insert('smiley-laughing.gif','emotions_dlg.laughing');"><img src="img/smiley-laughing.gif" width="18" height="18" border="0" alt="{#emotions_dlg.laughing}" title="{#emotions_dlg.laughing}" /></a></td>
		  </tr>
		  <tr>
			<td><a href="javascript:EmotionsDialog.insert('smiley-money-mouth.gif','emotions_dlg.money_mouth');"><img src="img/smiley-money-mouth.gif" width="18" height="18" border="0" alt="{#emotions_dlg.money_mouth}" title="{#emotions_dlg.money_mouth}" /></a></td>
			<td><a href="javascript:EmotionsDialog.insert('smiley-sealed.gif','emotions_dlg.sealed');"><img src="img/smiley-sealed.gif" width="18" height="18" border="0" alt="{#emotions_dlg.sealed}" title="{#emotions_dlg.sealed}" /></a></td>
			<td><a href="javascript:EmotionsDialog.insert('smiley-smile.gif','emotions_dlg.smile');"><img src="img/smiley-smile.gif" width="18" height="18" border="0" alt="{#emotions_dlg.smile}" title="{#emotions_dlg.smile}" /></a></td>
			<td><a href="javascript:EmotionsDialog.insert('smiley-surprised.gif','emotions_dlg.surprised');"><img src="img/smiley-surprised.gif" width="18" height="18" border="0" alt="{#emotions_dlg.surprised}" title="{#emotions_dlg.surprised}" /></a></td>
			<td><a href="javascript:EmotionsDialog.insert('smiley-tongue-out.gif','emotions_dlg.tongue_out');"><img src="img/smiley-tongue-out.gif" width="18" height="18" border="0" alt="{#emotions_dlg.tongue-out}" title="{#emotions_dlg.tongue_out}" /></a></td>
			<td><a href="javascript:EmotionsDialog.insert('smiley-undecided.gif','emotions_dlg.undecided');"><img src="img/smiley-undecided.gif" width="18" height="18" border="0" alt="{#emotions_dlg.undecided}" title="{#emotions_dlg.undecided}" /></a></td>
			<td><a href="javascript:EmotionsDialog.insert('smiley-wink.gif','emotions_dlg.wink');"><img src="img/smiley-wink.gif" width="18" height="18" border="0" alt="{#emotions_dlg.wink}" title="{#emotions_dlg.wink}" /></a></td>
			<td><a href="javascript:EmotionsDialog.insert('smiley-yell.gif','emotions_dlg.yell');"><img src="img/smiley-yell.gif" width="18" height="18" border="0" alt="{#emotions_dlg.yell}" title="{#emotions_dlg.yell}" /></a></td>
		  </tr>
		 </tbody>
		</table>

		<div style="height: 15px"></div>

		<table border="0" cellspacing="0" cellpadding="4">
		<thead>
		<tr>
			<th colspan="5">애니매이션 이모티콘 (1)</th>
		</tr>
		</thead>
		<tbody>
		  <tr>
		  <?php for($i=1; $i<90; $i++) { ?>
			<td><a href="javascript:EmotionsDialog.insert('animated/animate_emotion_<?php echo $i; ?>.gif','emotions_dlg.cool');" title="여기를 클릭하시면 이 이모티콘을 본문 커서 위치에 삽입합니다."><img src="img/animated/animate_emotion_<?php echo $i; ?>.gif" border="0" alt="이모티콘" /></a></td>
		 <?php
			if($i % 5 == 0) echo '</tr><tr>';
		 } // animated emoticons ?>
		 <td></td>
		  </tr>
		 </tbody>
		</table>


		<div style="height: 15px"></div>

		<table border="0" cellspacing="0" cellpadding="4">
		<thead>
		<tr>
			<th colspan="5">애니매이션 이모티콘 (2)</th>
		</tr>
		</thead>
		<tbody>
		  <tr>
		  <?php for($i=1; $i<40; $i++) { ?>
			<td><a href="javascript:EmotionsDialog.insert('rabbit/rabbit_<?php echo $i; ?>.gif','emotions_dlg.cool');" title="여기를 클릭하시면 이 이모티콘을 본문 커서 위치에 삽입합니다."><img src="img/rabbit/rabbit_<?php echo $i; ?>.gif" border="0" alt="이모티콘" /></a></td>
		 <?php
			if($i % 5 == 0) echo '</tr><tr>';
		 } // animated emoticons ?>
		 <td></td>
		  </tr>
		 </tbody>
		</table>

		<div style="height: 15px"></div>

		<table border="0" cellspacing="0" cellpadding="4">
		<thead>
		<tr>
			<th colspan="5">애니매이션 이모티콘 (3)</th>
		</tr>
		</thead>
		<tbody>
		  <tr>
		  <?php for($i=1; $i<105; $i++) { ?>
			<td><a href="javascript:EmotionsDialog.insert('onion_club/onion_club_<?php echo $i; ?>.gif','emotions_dlg.cool');" title="여기를 클릭하시면 이 이모티콘을 본문 커서 위치에 삽입합니다."><img src="img/onion_club/onion_club_<?php echo $i; ?>.gif" border="0" alt="이모티콘" /></a></td>
		 <?php
			if($i % 5 == 0) echo '</tr><tr>';
		 } // animated emoticons ?>
		 <td></td>
		  </tr>
		 </tbody>
		</table>

</body>
</html>