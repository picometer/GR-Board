<?php
/***************
 * 기본 새 쪽지 알림상자
 ***************
- 이 파일은 grboard/view.php 위치에서 불려집니다.
- 알림상자는 독립된 스타일시트를 사용할 수 없습니다. 
  (강제로 지정하여 사용하는 것은 가능함 → 대신 웹표준은 준수 못하게 됩니다.)
- 알림상자는 되도록 이미지 파일 하나를 부르는 역할만 하는 게 제일 좋습니다.
- 강제로 스타일을 지정하지 않는 이상 쪽지 알림 메시지는 브라우저 우측 상단 구석에 나타납니다.
- 기본적으로 newMsgCheck 라는 DIV 레이어 안에 아래 img 태그 (혹은 문장) 이 출력됩니다.
- 이 테마 폴더명 변수는 $getNotify['var'] 에 저장되어 있습니다.
 */
if(!defined('__GRBOARD__')) exit();

// 그림 등의 경로에 사용
$notifyPath = 'admin/theme/memo_notify/'.$getNotify['var'];
?>
<?php
 /* Skin By_ STUDIO-D (www.studio-d.kr)
 이동규(장화신은고양이) */
?>
<a href="view_memo.php" onclick="window.open(this.href, '_blank', 'width=600,height=700,menubar=no,scrollbars=yes'); return false" title="이 곳을 클릭하여 새로온 쪽지를 확인합니다."><img src="<?php echo $notifyPath; ?>/notify_box.png" alt="새 쪽지 알림" /></a>