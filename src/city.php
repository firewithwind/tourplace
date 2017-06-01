<?php
	include("conn.php");
	include("request.php");
	session_start();
	
	switch ($request_method) {
		case 'GET':
			IFGET($request_data);
			break;
		case 'POST':
			IFPOST($request_data);
			break;
		case 'DELETE':
			IFDELETE($request_data);
			break;
		default:
			break;
	}
	
/*тЖ*/
function IFPOST($request_data){
	
}

/*и╬*/
function IFDELETE($request_data){
	
}

/*╡И*/
function IFGET($request_data){
	
}

function getID(){
	if(!@$f=fopen("ID_Record\City_ID.txt","r")){
		$ID_0=1;
		$ff=fopen("ID_Record\City_ID.txt","w");
		fwrite($ff,$ID_0);
		fclose($ff);
	}else{
		$ID_0=fgets($f,10);
		fclose($f);
		$ID_0++;
		$ff=fopen("ID_Record\City_ID.txt","w");
		fwrite($ff,$ID_0);
		fclose($ff);
	}
	if(strlen($ID_0)>8)/*idрябЗ*/
		return '99999999';
	else{
		$num=8-strlen($ID_0);
		while($num>0){
			$ID_0='0'.$ID_0;
			$num--;
		}
		return $ID_0;
	}
}

?>