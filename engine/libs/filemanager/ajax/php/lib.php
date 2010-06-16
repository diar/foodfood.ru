<?php
/**
 * Ajex.FileManager
 * http://demphest.ru/ajex-filemanager
 *
 * @version
 * 1.1 (15 Dec 2009)
 *
 * @copyright
 * Copyright (C) 2009 Demphest Gorphek
 *
 * @license
 * Dual licensed under the MIT and GPL licenses.
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Ajex.FileManager is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This file is part of Ajex.FileManager.
 */


isset($_GET['isWork'])? isWork() : null;

if (isset($_GET['downloadFile'])) {

	$file = realpath($cfg['root'] . trim($_GET['downloadFile'], '/\\'));
	$file = str_replace('\\', DIR_SEP, $file);
	if (empty($file) || false === strpos($file, str_replace('\\', DIR_SEP, $cfg['root']))) {
		header("HTTP/1.0 404 Not Found");
		exit;
	}

	$inf = pathinfo($file);
	if (!in_array(strtolower($inf['extension']), $cfg['allow']['file'])) {
		header("HTTP/1.0 404 Not Found");
		exit;
	}
	$inf['size'] = filesize($file);

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: private", false);
	header("Content-Disposition: attachment; filename=" . urlencode($inf['basename']));
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Description: File Transfer");
	header("Content-Length: " . $inf['size']);

	if (50000000 > $inf['size']) {
		flush();
		$fp = fopen($file, "r");
		while (!feof($fp)) {
	    	echo fread($fp, 65536);
	    	flush();
		}
		fclose($fp);
	} else {
		readfile($file);
	}

	exit;
}

function listDirs($dir)
{
	global $cfg;
	$list	= array();

	$full	= $cfg['root'] . trim($dir, '/\\') . DIR_SEP;
	$dirs	= scandir($full);
	for ($i=-1, $iCount=count($dirs); ++$i<$iCount;) {
		if (is_dir($full . $dirs[$i]) && !in_array($dirs[$i], $cfg['hide']['folder'])) {
			$stats = getSize($full . $dirs[$i] . DIR_SEP, 'dir');
			$list[] = array(
						'title'		=> $dirs[$i] . ' <i>' . $stats['_size'] . '</i>',
						'key'		=> urlencode($dir . $dirs[$i]),
						'isLazy'	=> true,
						'isFolder'	=> true
				);
		}
	}

	return $list;
}

function listFiles($dir)
{
	global $cfg;
	$list = array();

	$full		= $cfg['root'] . trim($dir, '/\\') . DIR_SEP;
	$thumb	= $cfg['root'] . $cfg['thumb']['dir'] . DIR_SEP . trim($dir, '/\\') . DIR_SEP;

	$files = scandir($full);
	natcasesort($files);
	for ($i=-1, $iCount=count($files); ++$i<$iCount;) {
		$ext = substr($files[$i], strrpos($files[$i], '.') + 1);
		$ext = strtolower($ext);
		if (!in_array($files[$i], $cfg['hide']['file']) && !in_array($ext, $cfg['deny'][$cfg['type']]) && in_array($ext, $cfg['allow'][$cfg['type']]) && is_file($full . $files[$i])) {

			$imgSize = array(0, 0);
			if (in_array($ext, $cfg['allow']['image'])) {
				if ($cfg['thumb']['auto'] && !file_exists($thumb . $files[$i])) {
					create_thumbnail($full . $files[$i], $thumb . $files[$i]);
				}
				$imgSize = getimagesize($full . $files[$i]);
			}

			$stats = getSize($full . $files[$i]);

			$list[] = array(	'name'	=> $files[$i],
								'ext'		=> $ext,
								'width'	=> $imgSize[0],
								'height'	=> $imgSize[1],
								'size'		=> $stats['_size'],
								'date'		=> date($cfg['thumb']['date'], $stats['mtime']),
								'r_size'	=> $stats['size'],
								'mtime'	=> $stats['mtime'],
								'thumb'	=> '/' . $cfg['url'] . '/' . $cfg['thumb']['dir'] . '/' . $dir . $files[$i]
				);
		}
	}

	switch($cfg['sort']) {
		case 'size':
			usort($list, 'sortSize');
			break;
		case 'date':
			usort($list, 'sortDate');
			break;
		default:	//name
			break;
	}

	return $list;
}


function dirSize($dirFile)
{
	$size = 0;
	$dir = opendir($dirFile);
	if (!$dir) return false;

	while (false !== ($f = readdir($dir))) {
		if ($f[0] == '.') continue;
		if (is_dir($dirFile . $f)) {
			$size += dirSize($dirFile . $f . DIR_SEP);
		} else {
			$size += filesize($dirFile . $f);
		}
	}
	closedir($dir);
	return $size;
}

function getSize($dirFile, $mode = 'file')
{
	if ('file' == $mode) {
		$stats = stat($dirFile);
	} elseif ('dir' == $mode) {
		$stats['size'] = dirSize($dirFile);
	}

	if (empty($stats['size'])) {
		$stats['_size'] = '';
	} elseif ($stats['size'] < 1024) {
		$stats['_size'] .= ' B';
	} elseif ($stats['size'] < 1048576) {
		$stats['_size'] = round($stats['size'] / 1024) . ' KB';
	} else {
		$stats['_size'] = round($stats['size'] / 1048576, 2) . ' MB';
	}

	return $stats;
}


function create_thumbnail($orig_fname, $thum_fname, $thumb_width = null, $thumb_height = null, $quality = null, $do_cut = null, $uploadResize = false)
{
	if (!mkdirs(dirname($thum_fname))) {
		return false;
	}

	$size	= @getimagesize($orig_fname);
	if (false === $size) {
		return false;
	}

	$rgb	= 0xFFFFFF;
	$src_x = $src_y = 0;

	$format	= strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));
	$icfunc	= 'imagecreatefrom' . $format;
	if (!function_exists($icfunc)) {
		return false;
	}

	0 === $thumb_width? $thumb_width = $size[0] : null;
	0 === $thumb_height? $thumb_height = $size[1] : null;

	global $cfg;
	null === $thumb_width?		$thumb_width	= $cfg['thumb']['width'] : null;
	null === $thumb_height?	$thumb_height	= $cfg['thumb']['height']: null;
	null === $quality?		$quality	= $cfg['thumb']['quality']	: null;
	null === $do_cut?	$do_cut	= $cfg['thumb']['cut']	: null;

	$path = pathinfo($thum_fname);
	if (!is_dir($path['dirname'])) {
		$is = mkdir($path['dirname'], $cfg['chmod']['folder']);
		if (!$is) {
			return false;
		}
	}

	$orig_img = $icfunc($orig_fname);
	if (($size[0] <= $thumb_width) && ($size[1] <= $thumb_height)) {
		$width  = $size[0];
		$height = $size[1];

	} else {
		$width  = $thumb_width;
		$height = $thumb_height;

		$ratio_width  = $size[0] / $thumb_width;
		$ratio_height = $size[1] / $thumb_height;

		if ($ratio_width < $ratio_height) {
			if ($do_cut) {
				$src_y = ($size[1] - $thumb_height * $ratio_width) / 2;
				$size[1] = $thumb_height * $ratio_width;
			} else {
				$width  = $size[0] / $ratio_height;
				$height = $thumb_height;
			}

		} else {
			if ($do_cut) {
				$src_x = ($size[0] - $thumb_width * $ratio_height) / 2;
				$size[0] = $thumb_width * $ratio_height;
			} else {
				$width  = $thumb_width;
				$height = $size[1] / $ratio_width;
			}

		}
	}

	$thum_img = imagecreatetruecolor($width, $height);
	imagefill($thum_img, 0, 0, $rgb);
	imagecopyresampled($thum_img, $orig_img, 0, 0, $src_x, $src_y, $width, $height, $size[0], $size[1]);

	//if (function_exists($image_ = 'image' . $format)) {
		//$image_($thum_img, $thum_fname, $quality);
	//} else {
		imagejpeg($thum_img, $thum_fname, $quality);
	//}

	flush();
	imagedestroy($orig_img);
	imagedestroy($thum_img);

	return true;
}

function getFreeFileName($fileName, $dir)
{
	global $cfg;
	$dir = rtrim($dir, DIR_SEP) . DIR_SEP;

	$strlen = mb_strlen($fileName, 'utf-8');
	$dotPos= mb_strrpos($fileName, '.', null, 'utf-8');

	$fname = mb_substr($fileName, 0, mb_strrpos($fileName, '.', null, 'utf-8'), 'utf-8');
	$format = mb_substr($fileName, $dotPos+1, ($strlen-$dotPos), 'utf-8');

	$langDir = dirname(__FILE__);
	if (file_exists($langPhp = $langDir . DIR_SEP . 'lang' . DIR_SEP . $cfg['lang'] . '.php')) {
		require_once $langPhp;
	}
	if (!function_exists('translit')) {
		function translit($str) {
			return $str;
		}
	}

	$fname = translit($fname);
	$f = $fname . '.' . $format;

	if (file_exists($dir . $f)) {


		if (false !== ($pos = strrpos($f, '_')) && !in_array($f{$pos+1}, array(0,1,2,3,4,5,6,7,8,9))) {
			$symname = substr($f, 0, $pos);
		} else {
			$symname = $fname;
		}


		$symname = $fname;

		$i = 0;
		$exist = true;
		while ($exist && ++$i < 777) {// :)
			$new_name = $symname . '_(' . $i . ').' . $format;
			if (!file_exists($dir . $new_name)) {
				$exist = false;
				$f = $new_name;
			}
		}
	}

	return $f;
}

function deleteDir($dirname)
{
	global $cfg;

	if (!file_exists($dirname)) {
		return false;
	}

	if (is_file($dirname)) {
		return unlink($dirname);
	}

	$dir = dir($dirname);
	while (false !== $entry = $dir->read()) {
		if ('.' == $entry || '..' == $entry) {
			continue;
		}

		deleteDir($dirname . DIR_SEP . $entry);
	}

	$dir->close();

	return rmdir($dirname);
}

function mkdirs($dir, $mode=0777)
{
	if (empty($dir)) {
		return false;
	}

	if (is_dir($dir) || '/' === $dir) {
		return true;
	}

	if (mkdirs(dirname($dir), $mode)) {
		return mkdir($dir, $mode);
	}

	return false;
}

function sortDate($a, $b)
{
	if ($a['mtime'] == $b['mtime'])		return -1;
	if ($a['mtime'] < $b['mtime'])		return 1;
	return 0;
}
function sortSize($a, $b)
{
	if ($a['r_size'] == $b['r_size'])		return -1;
	if ($a['r_size'] < $b['r_size'])		return 1;
	return 0;
}

if (!function_exists('scandir')) {
	function scandir($dir)
	{
		$dh	= opendir($dir);
		$files	= array();
		while (false !== ($filename = readdir($dh))) {
			$files[] = $filename;
		}

		return $files;
	}
}

function isWork()
{
	header('Content-Type: text/html; charset=utf-8');
	global $cfg;
	if (!is_dir($cfg['root'])) {
		echo 'Directory not found: ' . $cfg['root'], '<br />';
		if (mkdirs($cfg['root'], $cfg['chmod']['folder'])) {
			echo 'Successfully created';
		} else {
			echo 'Failed created, You need to create the folder manually, or set the right<br />Вам необходимо создать папку вручную, или выставить права';
			exit;
		}
	} elseif (!is_writable($cfg['root'])) {
		echo 'No write access to folder: ' . $cfg['root'], '<br />Нет доступа на запись.';
	} else {
		echo '<font color=green>Root directory in order<br />Корневая директория в порядке.</font>';
	}
	echo '<hr />';

	$type = array($cfg['thumb']['dir'], 'file', 'flash', 'image');
	for ($i=-1;++$i<4;) {
		$d = $cfg['root'] . $type[$i];
		if (!is_dir($d)) {
			echo 'Directory not found: ' . $d, '<br />';
			if (mkdirs($d, $cfg['chmod']['folder'])) {
				echo 'Successfully created';
			} else {
				echo 'Failed created, You need to create the folder manually, or set the right<br />Вам необходимо создать папку вручную, или выставить права';
				exit;
			}
		} elseif (!is_writable($d)) {
			echo 'No write access to folder: ' . $d, '<br />Нет доступа на запись.';
		} else {
			echo $type[$i] . ' - <font color=green>normal</font>';
		}
		echo '<br />';
	}
	echo '<hr />';

	echo 'Check available extensions: ';
	$ext = array('json_encode', 'mb_internal_encoding', 'mb_substr', 'mb_ereg_replace', 'mb_strlen', 'imagecreatetruecolor', 'imagefill', 'imagecopyresampled', 'imagejpeg', 'imagedestroy');
	for ($i=-1, $iCount=count($ext); ++$i<$iCount;) {
		echo '<br />';
		echo function_exists($ext[$i])? $ext[$i] . ' - <font color=green>yes</font> ' : $ext[$i] . ' - <font color=red>no</font>';
	}

	exit;
}