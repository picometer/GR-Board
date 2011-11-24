<?php @header('Content-Type: text/html; charset=utf-8'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>GR Board Theme Preview</title>
</head>
<body>
<img src="<?php echo htmlspecialchars($_GET['src']); ?>" alt="테마 미리보기" title="스크린샷을 더블클릭 시 이 창을 닫습니다." ondblclick="window.close()" />
</body>
</html>