<?php

function translit($input_string)
{
	$trans = array();
	$ch1 = "/\r\n-абвгдеёзийклмнопрстуфхцыэАБВГДЕЁЗИЙКЛМНОПРСТУФХЦЫЭABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$ch2 = "    abvgdeeziyklmnoprstufhcyeabvgdeeziyklmnoprstufhcyeabcdefghijklmnopqrstuvwxyz";
	for($i=0; $i<mb_strlen($ch1); $i++)
		$trans[mb_substr($ch1, $i, 1)] = mb_substr($ch2, $i, 1);
	$trans["Ж"] = "zh";  $trans["ж"] = "zh";
	$trans["Ч"] = "ch";  $trans["ч"] = "ch";
	$trans["Ш"] = "sh";  $trans["ш"] = "sh";
	$trans["Щ"] = "sch"; $trans["щ"] = "sch";
	$trans["Ъ"] = "";    $trans["ъ"] = "";
	$trans["Ь"] = "";    $trans["ь"] = "";
	$trans["Ю"] = "yu";  $trans["ю"] = "yu";
	$trans["Я"] = "ya";  $trans["я"] = "ya";
	$trans["\\\\"] = " ";
	$trans["[^\. a-z0-9]"] = " ";
	$trans["^[ ]+|[ ]+$"] = "";
	$trans["[ ]+"] = "_";
	foreach($trans as $from=>$to)
		$input_string = mb_ereg_replace(str_replace("\\", "\\", $from), $to, $input_string);
	return $input_string;
}
