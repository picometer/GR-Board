<?php
function makeLatestThumb($file, $theme, $id, $grboard, $max_width=50, $max_height=50)
{
	if(!file_exists($file)) return '<img src="'.$theme.'/no_img.gif" />';
	if(!is_dir("{$grboard}/data/{$id}/latest_thumb"))
	{
		mkdir("{$grboard}/data/{$id}/latest_thumb", 0705);
		chmod("{$grboard}/data/{$id}/latest_thumb", 0707);
	}
	$tmpArr = explode("/", $file);
	$tmpTarget  = $tmpArr[count($tmpArr)-1];
	$tmpThumbFile = $grboard.'/data/'.$id.'/latest_thumb/thumb_'.$tmpTarget;
	$saveFile = $tmpThumbFile;
	if(file_exists($tmpThumbFile))
	{
		$tmpSize = @getimagesize($tmpThumbFile);

		if(($tmpSize[0] == $max_width) || ($tmpSize[1] == $max_height))
		{
			return '<img src="'.$tmpThumbFile.'" alt="thumbnail image" />';
		}
		else
		{
			@unlink($tmpThumbFile);
			$tmpImage = @getimagesize($file);
			switch($tmpImage[2])
			{
				case 1:	$srcImage = imagecreatefromgif($file); break;
				case 2:	$srcImage = imagecreatefromjpeg($file); break;
				case 3:	$srcImage = imagecreatefrompng($file);	break;
				case 6:	$srcImage = imagecreatefromwbmp($file); break;
				default : return '<img src="'.$theme.'/no_img.gif" alt="thumbnail image" />';
			}
			$imageWidth = $tmpImage[0];
			$imageHeight = $tmpImage[1];
			if(($imageWidth/$max_width) == ($imageHeight/$max_height))
			{
				$dstWidth=$max_width;
				$dstHeight=$max_height;
			}
			elseif(($imageWidth/$max_width) < ($imageHeight/$max_height))
			{
				$dstWidth=$max_height*($imageWidth/$imageHeight);
				$dstHeight=$max_height;
			}
			else
			{
				$dstWidth=$max_width;
				$dstHeight=$max_width*($imageHeight/$imageWidth);
			}
			$dstImage = @imagecreatetruecolor($dstWidth, $dstHeight);
			$thumbImage = @imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $dstWidth, $dstHeight, $imageWidth, $imageHeight);
			if(!$thumbImage) $thumbImage = @imagecopyresized($dstImage, $srcImage, 0, 0, 0, 0, $dstWidth, $dstHeight, $imageWidth, $imageHeight);
			@imageinterlace($dstImage);
			switch($tmpImage[2])
			{
				case 1:	Imagegif($dstImage, $saveFile); break;
				case 2:	Imagejpeg($dstImage, $saveFile); break;
				case 3:	Imagepng($dstImage, $saveFile); break;
				case 6:	Imagewbmp($dstImage, $saveFile); break;
				default : return '<img src="'.$theme.'/no_img.gif" alt="thumbnail image" />';
			}
			@imagedestroy($dstImage);
			@imagedestroy($srcImage);
			return '<img src="'.$saveFile.'" alt="thumbnail image" />';
		}
	}
	else
	{
		$tmpImage = @getimagesize($file);
		switch($tmpImage[2])
		{
			case 1:	$srcImage = imagecreatefromgif($file); break;
			case 2:	$srcImage = imagecreatefromjpeg($file); break;
			case 3:	$srcImage = imagecreatefrompng($file);	break;
			case 6:	$srcImage = imagecreatefromwbmp($file); break;
			default : return '<img src="'.$theme.'/no_img.gif" alt="thumbnail image" />';
		}
		$imageWidth = $tmpImage[0];
		$imageHeight = $tmpImage[1];
		if(($imageWidth/$max_width) == ($imageHeight/$max_height))
		{
			$dstWidth=$max_width;
			$dstHeight=$max_height;
		}
		elseif(($imageWidth/$max_width) < ($imageHeight/$max_height))
		{
			$dstWidth=$max_height*($imageWidth/$imageHeight);
			$dstHeight=$max_height;
		}
		else
		{
			$dstWidth=$max_width;
			$dstHeight=$max_width*($imageHeight/$imageWidth);
		}
		$dstImage = @imagecreatetruecolor($dstWidth, $dstHeight);
		$thumbImage = @imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $dstWidth, $dstHeight, $imageWidth, $imageHeight);
		if(!$thumbImage) $thumbImage = @imagecopyresized($dstImage, $srcImage, 0, 0, 0, 0, $dstWidth, $dstHeight, $imageWidth, $imageHeight);
		@imageinterlace($dstImage);
		switch($tmpImage[2])
		{
			case 1:	Imagegif($dstImage, $saveFile); break;
			case 2:	Imagejpeg($dstImage, $saveFile); break;
			case 3:	Imagepng($dstImage, $saveFile); break;
			case 6:	Imagewbmp($dstImage, $saveFile); break;
			default : return '<img src="'.$theme.'/no_img.gif" alt="thumbnail image" />';
		}
		@imagedestroy($dstImage);
		@imagedestroy($srcImage);
		return '<img src="'.$saveFile.'" alt="thumbnail image" />';
	}
}
?>