<?php
$grboard = str_replace('/'.end(explode('/', $_SERVER['REQUEST_URI'])), '', $_SERVER['REQUEST_URI']);
$styleURL = $grboard;
$_GET['htmlHeadAdd'] = $_POST['htmlHeadAdd'] = $_REQUEST['htmlHeadAdd'] = '';
if($getOutlogin['var']) $styleURL = $grboard.'/admin/theme/outlogin/'.$getOutlogin['var'];
if($getJoinus['var']) $styleURL = $grboard.'/admin/theme/join/'.$getJoinus['var'];
if($getScrapView['var']) $styleURL = $grboard.'/admin/theme/scrap/'.$getScrapView['var'];
if($getMemo['var']) $styleURL = $grboard.'/admin/theme/memo/'.$getMemo['var'];
if($getReport['var']) $styleURL = $grboard.'/admin/theme/report/'.$getReport['var'];
if($getInformation['var']) $styleURL = $grboard.'/admin/theme/info/'.$getInformation['var'];
if($preRoute) $styleURL = $preRoute;
?>
<!doctype html>
<html>
<head>
<link rel="stylesheet" href="<?php echo $styleURL; ?>/style.css" type="text/css" title="style" />
<meta charset="utf-8" />
<?php echo $htmlHeadAdd; ?>
<title><?php echo $title; ?></title>
</head>