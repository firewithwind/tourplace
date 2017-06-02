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
	if(isset($request_data['Province_Name'])){
		$name=$request_data['Province_Name'];
		$ID=getID();
		if($ID=='99999999'){/*失败*/
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.The ID is fulled!")));
		}else{/*成功*/
			$sql="INSERT INTO `tourplace`.`province`(`Province_ID`,`Province_Name`)
				VALUES('$ID','$name')";
			mysql_query($sql);
			echo json_encode(array('Type'=>0,'Result'=>array('Province_ID'=>$ID)));
		}
	}else{
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The province name is empty!")));
	}
}

/*查*/
function IFGET($request_data){
	if($request_data['Type']==0){
		$result=array();
		$sql="SELECT `Province_ID`,`Province_Name` FROM `province`";
		$query=mysql_query($sql);
		while($row=mysql_fetch_assoc($query)){
			$Citys=array();
			$proid=$row['Province_ID'];
			$sql1="SELECT `City_ID`,`City_Name` FROM `city` WHERE `Province_ID`='$proid'";
			$query1=mysql_query($sql1);
			while($row1=mysql_fetch_assoc($query1))
				$Citys[]=array('City_ID'=>$row1['City_ID'],'City_Name'=>$row1['City_Name']);
			$result[]=array('Province_ID'=>$row['Province_ID'],'Province_Name'=>$row['Province_Name'],'Citys'=>$Citys);
		}
		$resultcount=count($result);
		echo json_encode(array('Type'=>0,'Size'=>$resultcount,'Result'=>$result));
	}else{
		echo json_encode(array('Type'=>1,'Size'=>0,'Result'=>array('Errmsg'=>"1.The request is error!")));
	}
}

function getID(){
	if(!@$f=fopen("ID_Record\Province_ID.txt","r")){
		$ID_0=1;
		$ff=fopen("ID_Record\Province_ID.txt","w");
		fwrite($ff,$ID_0);
		fclose($ff);
	}else{
		$ID_0=fgets($f,10);
		fclose($f);
		$ID_0++;
		$ff=fopen("ID_Record\Province_ID.txt","w");
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