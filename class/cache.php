<?php
// 페이지 캐쉬 인터페이스; PHP4 & PHP5 호환; 실험적인 인터페이스;
class CACHE
{
	// 지정된 위치에 캐쉬파일 저장소 생성
	function makeCacheDir($dir)
	{
		if(is_dir($dir)) return;		
		@mkdir($dir, 0705);
		@chmod($dir, 0707);
	}

	// 캐쉬 대상파일 내용을 가져온다.
	function getHTML($url)
	{
		$url = $url.'?pageCache=0';
		$parse = parse_url($url);
		if(!$parse['port']) $parse['port'] = 80;
		$fp = fsockopen($parse['host'], $parse['port']);
		if(!$fp) return 0;
		fputs($fp, "GET ".$url." HTTP/1.0\r\nHost: ".$parse['host'].":".$parse['port']."\r\nUser-Agent: GR Board\r\n\r\n");
		$content = "";
		while(!feof($fp)) $content .= fgets($fp, 4096);
		fclose($fp);
		$result = preg_replace('|HTTP.+?<html|is', '<html', $content);
		return $result;
	}

	// 가져온 내용을 HTML 파일로 저장한다. (확장자 유지)
	function saveToHTML($url, $dir)
	{
		$saveHTML = $this->getHTML($url);
		$tmpName = explode('/', $url);
		$filename = $tmpName[count($tmpName)-1];
		$result = time().'_'.$filename;
		$op = fopen($dir.'/'.$result, 'w');
		fwrite($op, $saveHTML);
		fclose($op);
		return $result;
	}

	// url 에서 파일이름을 가져온다.
	function getLatestCache($url, $dir)
	{
		$hd = opendir($dir);
		while($file = readdir($hd))
		{
			if($file == '.' or $file == '..') continue;
			if($file) return $file;
		}
		return 'file_is_not_fount_for_cache';
	}

	// 이전 캐쉬 삭제
	function deleteCache($dir)
	{
		$hd = opendir($dir);
		while($file = readdir($hd))
		{
			if($file == '.' or $file == '..') continue;
			@unlink($dir.'/'.$file);
		}
	}

	// 캐쉬파일 저장
	function saveCache($url, $dir='cache', $updateTerm=30)
	{
		$this->makeCacheDir($dir);
		$latestCache = $this->getLatestCache($url, $dir);
		if(file_exists($dir.'/'.$latestCache))
		{
			$tmpName = explode('_', $latestCache);
			$latestTime = $tmpName[0];
			if(time() > ($latestTime + $updateTerm))
			{
				$this->deleteCache($dir);
				$newFileName = $this->saveToHTML($url, $dir);
				include $dir.'/'.$newFileName;
			}
			else include $dir.'/'.$latestCache;
		}
		else
		{
			$this->deleteCache($dir);
			$newFileName = $this->saveToHTML($url, $dir);
			include $dir.'/'.$newFileName;
		}
		exit();
	}
}
?>