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
		default:
			break;
	}
	
/*增*/
function IFPOST($request_data){
	if(empty($request_data['Province_ID'])||
	   empty($request_data['City_Name'])){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The information is incomplete!")));
	}else{
		$proid=$request_data['Province_ID'];
		$cityname=$request_data['City_Name'];
		$cityid=getID();
		if($cityid=='99999999'){/*失败*/
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.The ID is fulled!")));
		}else{/*成功*/
			$sql="INSERT INTO `tourplace`.`province`(`City_ID`,`City_Name`,`Province_ID`)
				VALUES('$cityid','$cityname','$proid')";
			mysql_query($sql);
		}
	}
}

/*查*/
function IFGET($request_data){
	$sql="";
	if(empty($request_data['Keys'])){
		$sql="SELECT *";
	}else{
		$sql="SELECT ";
		$Key=explode('+',$request_data['Keys']);
		$arrcount=count($Key);
		$i=0;
		while($i<$arrcount){
			$sql.="`".$Key[$i]."`";
			if($i!=$arrcount-1) $sql.=",";
			$i++;
		}
	}
	$sql.=" FROM `tourplace`.`city` WHERE 1";
	if($request_data['Type']==0){
		if(!empty($request_data['Search']['City_ID'])){
			$cityid=$request_data['Search']['City_ID'];
			$sql.=" AND `City_ID`='$cityid'";
		}
		nextstep($request_data,$sql);
	}else if($request_data['Type']==1){
		if(!empty($request_data['Search']['Province_ID'])){
			$proid=$request_data['Search']['Province_ID'];
			$sql.=" AND `Province_ID`='$proid'";
		}
		if(!empty($request_data['Search']['City_Name'])){
			$cityname=$request_data['Search']['City_Name'];
			$sql.=" AND `City_Name`='$cityname'";
		}
		nextstep($request_data,$sql);
	}else{
		echo json_encode(array('Type'=>1,'Size'=>0,'Result'=>array('Errmsg'=>"1.The request is error!")));
	}
}

function nextstep($request_data,$sql){
	$result=array();
	$page=$request_data['Page'];
	$pagesize=$request_data['PageSize'];
	$query=mysql_query($sql);
	while($row=mysql_fetch_assoc($query))
		$result[]=$row;
	$resultcount=count($result);
	$pre=$pagesize*($page-1);
	if($pre>$resultcount){
		echo json_encode(array('Type'=>1,'Size'=>0,'Result'=>array('Errmsg'=>"1.The page number is error!")));
	}else{
		$finalresult=array();
		$finalcount=0;
		while($finalcount<$pagesize && $pre+$finalcount<$resultcount){
			$finalresult[]=$result[$pre+$finalcount];
			$finalcount++;
		}
		if($pagesize==0)
			echo json_encode(array('Type'=>0,'Size'=>$resultcount,'Result'=>$result));
		else
			echo json_encode(array('Type'=>0,'Size'=>$finalcount,'Result'=>$finalresult));
	}
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
	if(strlen($ID_0)>8)/*id已满*/
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