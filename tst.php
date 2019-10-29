<?
$data1=json_decode(file_get_contents("data.json"));
$data2=json_decode(file_get_contents("data2.json"));

define("OMS",6884);
define("OPS",29354);

$endtime=date("d.m.Y");

foreach($data1->suggestions as $k=>$v)
{
	$arr=GetInf($v,"01.04.2019",$endtime);
	show($arr);
}

foreach($data2->suggestions as $k=>$v)
{
	$arr=GetInf($v,"01.01.2019",$endtime);
	show($arr);
}

function GetInf($company,$begin,$end)
{
	
	$begin=strtotime($begin);
	$end=strtotime($end);	
	$date_reg=$company->data->state->registration_date/1000;
	
	if($date_reg>$begin){$begin=$date_reg;}
	
	$mass=array();
	$mass['NAME']=$company->value;
	$mass['INN']=$company->data->inn; 
	$mass['KV']="№ квартала";//???
	$mass['OMS']=Calc(OMS,$begin,$end);
	$mass['OPS']=Calc(OPS,$begin,$end);
	return $mass;
}

function Calc($sum,$begin,$end)
{
	//Полные месяцы
	$full=$sum/12*(date('n',$end)-date('n',$begin)-1);
	//Первый и последний месяц
	$first=$sum/12*(date('t',$begin)-date('d',$begin)+1)/date('t',$begin);
	$last=$sum/12*date('d',$end)/date('t',$end);
	
	return round($first+$full+$last,2);
}


function show($arr)
{
	echo "<pre>";print_r($arr);echo "</pre>";
}
?>