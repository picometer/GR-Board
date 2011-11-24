<!-- start page -->
<div id="page">
	<!-- start content -->
	<div id="content">
			<?php
			// 중간 최근 게시물 출력
			if($config['useLatest']) { 
				$boards = @explode('|', $config['showBoard']);
				$cntBoard = count($boards)-1;
				for($b=0; $b<$cntBoard; $b++) {
					$getLastPost = @mysql_fetch_array(mysql_query('select no, name, signdate from '.$dbFIX.'bbs_'.$boards[$b].' order by no desc limit 1'));
					echo '<div class="post">
					<p class="meta">Last post on '.date('Y-m-d', $getLastPost['signdate']).' by <a href="../board.php?id='.$boards[$b].'&amp;articleNo='.$getLastPost['no'].'">'.$getLastPost['name'].'</a></p>
					<div class="entry">';
					latest($config['latest'], $boards[$b], $config['latestNum'], 0, 0, 0, 'm.d', '<a href="../board.php?id='.$boards[$b].'">'.$boards[$b].'</a>');
					echo '</div></div>';
				}
			}
			?>
		</div>
	</div>
	<!-- end content -->
	<!-- start sidebar one -->
	<div id="sidebar1" class="sidebar">
		<ul>
			<li id="recent-posts">
				<h2>Sidebar Index</h2>
				<?php
				// 여기에 sidebar_index 페이지 내용을 가져옴
				$getSidebarIndex = @mysql_fetch_array(mysql_query('select var from '.$dbFIX.'layout_config where opt = \'page\' and var like \'sidebar_index%\' limit 1'));
				echo substr($getSidebarIndex['var'], 14);
				?>
			</li>
			<li id="live-poll">
				<?php 
				// 최근 설문조사 출력
				if($config['usePoll']) {
					echo '<h2>Live Poll</h2>';
					poll($config['poll']);
				}
				?>
			</li>
		</ul>
	</div>
	<!-- end sidebar one -->
	<!-- start sidebar two -->
	<div id="sidebar2" class="sidebar">
		<ul>
			<li>
				<h2>Menu</h2>
				<ul>
				<?php
				// 사이드 메뉴 가져와서 뿌려주기
				$getSideMenu = @mysql_query('select var from '.$dbFIX.'layout_config where opt = \'sidemenu\'');
				while($sideMenus = @mysql_fetch_array($getSideMenu)) { 
					$tmpArr = @explode('|', $sideMenus['var']);
					$sidemenuName = $tmpArr[0];
					$sidemenuLink = $tmpArr[1];
					echo '<li><a href="'.$sidemenuLink.'">'.$sidemenuName.'</a></li>';
				}
				?>
				</ul>
			</li>
		</ul>
	</div>
	<!-- end sidebar two -->
	<div style="clear: both;">&nbsp;</div>
</div>
<!-- end page -->