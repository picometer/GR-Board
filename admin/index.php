<?php
// 관리자인지 확인한다.
if($_SESSION['no'] != 1) { header("HTTP/1.0 404 Not Found"); exit; }
?>
