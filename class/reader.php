<?php
// RSS 리더 인터페이스; PHP4 & PHP5 호환; 일부 페이지는 접속이 안됨;
class READER
{
	// 원격 서버의 게시물을 가져온다.
	function getPage($url)
	{
		$parse = parse_url($url);
		if(!$parse['port']) $parse['port'] = 80;
		$fp = fsockopen($parse['host'], $parse['port']);
		if(!$fp) return 0;
		if($parse['query']) $parse['path'] .= '?';
		fputs($fp, 'GET '.$parse['path'].$parse['query']." HTTP/1.0\r\nHost: ".$parse['host']."\r\nUser-Agent: recently Post\r\n\r\n");
		$content = '';
		while(!feof($fp)) $content .= fgets($fp, 4096);
		if(($loc = strpos($content, 'Location:')) !== false)
		{
			$str = trim(substr($content, $loc + 9));
			$url = substr($str, 0, strpos($str, "\n")-1);
		}
		fclose($fp);
		if($loc) $content = $this->getPage($url);
		return $content;
	}

	// 헤더 부분을 제거한다.
	function deleteHeader($str)
	{
		$result = preg_replace('|HTTP.+?<\?xml|is', '<?xml', $str);
		return $result;
	}

	// 괄호처리
	function showTag($str)
	{
		$trans_tbl = get_html_translation_table(HTML_ENTITIES);
		$trans_tbl = array_flip($trans_tbl);
		return strtr($str, $trans_tbl);
	}

	// XML 의 각 요소들을 따로 담아서 반환. (워드프레스 참조 - wordpress.org)
	function rssView($url)
	{
		$result = array(array());
		$getPage = $this->getPage($url);
		if(!$getPage) return 0;
		$data = $this->deleteHeader($getPage);
		preg_match_all('|<item>(.*?)</item>|is', $data, $lists);
		$lists = $lists[1];
		$i = 0;
		foreach($lists as $rss)
		{
			$title = $date = $category = $content = $guid = $link = '';
			preg_match('|<title>(.*?)</title>|is', $rss, $title);
			$result[$i]['title'] = str_replace(array('<![CDATA[', ']]>'), '', $title[1]);
			preg_match('|<pubdate>(.*?)</pubdate>|is', $rss, $date);
			if($date[1]) $result[$i]['pubDate'] = $date[1];
			else
			{
				preg_match('|<dc:date>(.*?)</dc:date>|is', $rss, $date);
				$result[$i]['pubDate'] = str_replace('T', ' ', $date[1]);
			}
			preg_match('|<category>(.*?)</category>|is', $rss, $category);
			$result[$i]['category'] = $category[1];
			preg_match('|<link>(.*?)</link>|is', $rss, $link);
			if($link[1]) $result[$i]['link'] = $link[1];
			else
			{
				preg_match('|<guid.+?>(.*?)</guid>|is', $rss, $guid);
				$result[$i]['link'] = $guid[1];
			}
			preg_match('|<description>(.*?)</description>|is', $rss, $content);
			if($content[1]) $result[$i]['description'] = str_replace(array('<![CDATA[', ']]>'), '', $content[1]);
			else
			{
				preg_match('|<content:encoded>(.*?)</content:encoded>|is', $rss, $content);
				$result[$i]['description'] = str_replace(array('<![CDATA[', ']]>'), '', $content[1]);
			}
			$i++;
		}
		return $result;
	}
}
?>