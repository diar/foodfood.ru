<?
error_reporting(15);

//конфиг
include("config.php");

//подключаем класс GA API
include("gapi.class.php");

$ga = new gapi($u,$p);


//////получаем пользователи/просмотры за все время
$ga->requestReportData($id,array('month','year'),array('visitors','pageviews'),'year',null,$datestart, $datefinish,1,1000);

//переменная для записи резалта
$output="";
if($addFile) {$add=file_get_contents($path.$addFile); $output.=trim($add)."\n";}



//получаем и обрабатываем результаты
foreach($ga->getResults() as $result)
{
$m=$result; //месяц год
$visitors=$result->getVisitors(); //посетители
$pageviews=$result->getPageviews(); //просмотры

//приводим дату к удобочитаемому виду ,мменяем пробелы на точки
$m=str_replace(" ",".",$m);

//формируем строку
$output.=$m.";".$visitors.";".$pageviews."\n";
}

//пишем в файл
$fp=fopen($path.$visitorsCSV,"w");
fputs($fp,trim($output));
fclose($fp);




//////получаем пользователи/просмотры/посещения за последние 3 месяца
$ga->requestReportData($id,array('day','month','year'),array('visitors','visits','pageviews'),array('year','month'),null,$date3MonthStart, $date3MonthFinish,1,1000);

//переменная для записи резалта
$output="";


//получаем и обрабатываем результаты
foreach($ga->getResults() as $result)
{
$d=$result; //день
$visitors=$result->getVisitors(); //посетители
$pageviews=$result->getPageviews(); //просмотры
$visits=$result->getVisits(); //посещения

//приводим дату к удобочитаемому виду ,мменяем пробелы на точки
$d=str_replace(" ",".",$d);

//формируем строку
$output.=$d.";".$visitors.";".$pageviews.";".$visits."\n";
}

//пишем в файл
$fp=fopen($path.$visitors3CSV,"w");
fputs($fp,trim($output));
fclose($fp);






//////получаем географию посещений за последний месяц
$ga->requestReportData($id,array('country'),array('visits'),'-visits',null,$date1MonthStart, $date1MonthFinish,1,$countryRows);

//переменная для записи резалта
$output="";

//получаем общее число посещений для всех стран
$total_visits=$ga->getVisits();

//получаем и обрабатываем результаты
foreach($ga->getResults() as $result)
{
$country=$result->getCountry(); //страна
$visits=$result->getVisits(); //кол-во посещений

//нот сет переводим на русский
$country=str_replace("(not set)","не определено",$country);

//формируем строку
$output.=$country.";".$visits."\n";
}

//пишем в файл
$fp=fopen($path.$countryCSV,"w");
fputs($fp,trim($output));
fclose($fp);








//////получаем ГОРОДА за последний месяц
$ga->requestReportData($id,array('city'),array('visits'),'-visits',null,$date1MonthStart, $date1MonthFinish,1,$cityRows);

//переменная для записи резалта
$output="";

//получаем общее число посещений для всех стран
$total_visits=$ga->getVisits();

//получаем и обрабатываем результаты
foreach($ga->getResults() as $result)
{
$city=$result->getCity(); //страна
$visits=$result->getVisits(); //кол-во посещений

//нот сет переводим на русский
$city=str_replace("(not set)","не определено",$city);

//формируем строку
$output.=$city.";".$visits."\n";
}

//пишем в файл
$fp=fopen($path.$cityCSV,"w");
fputs($fp,trim($output));
fclose($fp);







?>