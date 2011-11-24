<div class="nowConnTitle"><?php echo $latestTitle; ?></div>
<?php
// 멤버 루프
while($conn = mysql_fetch_array($getData))
{
	$name = stripslashes($conn['nickname']);
	if($conn['nametag']) $name = '<img src="'.$grboard.'/'.$conn['nametag'].'" alt="'.$conn['nickname'].'" />';
	if($conn['icon']) $name = '<img src="'.$grboard.'/'.$conn['icon'].'" alt="" /> '.$name;
	?>
	<div class="nowConnList"><?php echo $name; ?></div>
	<?php
} # while

// 현재 접속자가 없다면...
if(!$name) { ?>
<div class="nowConnList">현재 접속한 멤버가 없습니다.</div>
<?php } ?>