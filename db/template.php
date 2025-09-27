<?php
class WSebsite{
		
	public function showDate(){
			return date('l, F d, Y');		
	}
	public function Member($company){
		return "$company Member Panel";
	}
	public function Adminn($company){
		return "$company Admin Panel";
	}
	public function Agent($company){
		return "$company Agent Panel";
	}
}
$acVbbb = "$_SERVER[HTTP_HOST]";
$erte=explode(".", $acVbbb);
$erter=count($erte);
if($erter==3){
	$Commn=strtoupper($erte[1]);
}else{
	$Commn=strtoupper($erte[0]);
}
//var_dump($Commn);
$kjhgdf=new WSebsite();
$ageASnt=$kjhgdf->Agent($Commn);
$Adminnb=$kjhgdf->Adminn($Commn);
$memberdd=$kjhgdf->Member($Commn);
?>	
	