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
	
/*增*/
function IFPOST($request_data){
	if(empty($request_data['Type'])){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.错误请求！")));
	}else if($request_data['Type']==1){
		$ScenicID=$request_data['Data']['Scenic_ID'];
		$sql="SELECT * FROM `tourplace`.`scenic` WHERE `Scenic_ID`='$ScenicID'";
		$rs=mysql_fetch_array(mysql_query($sql));
		$count=count($rs);
		if($count==0){
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.景点ID不存在！")));
		}else{
			$ID=getID();
			if($ID=='99999999'){
				echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"3.票号已满！")));
			}else{
				$Time=$request_data['Data']['Ticket_Time'];
				$Pic="xxx";
				$sql="INSERT INTO `tourplace`.`ticket`(`Ticket_ID`,`Scenic_ID`,`Ticket_Picture`,`Ticket_Time`)
				VALUES('$ID','$ScenicID','$Pic','$Time')";
				mysql_query($sql);
				echo json_encode(array('Type'=>0,'Result'=>""));
			}
		}
	}else{
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"4.没有权限！")));
	}
}

/*删*/
function IFDELETE($request_data){
	
}

/*查*/
function IFGET($request_data){
	
}

function getID(){
	if(!@$f=fopen("ID_Record\Ticket_ID.txt","r")){
		$ID_0=1;
		$ff=fopen("ID_Record\Ticket_ID.txt","w");
		fwrite($ff,$ID_0);
		fclose($ff);
	}else{
		$ID_0=fgets($f,10);
		fclose($f);
		$ID_0++;
		$ff=fopen("ID_Record\Ticket_ID.txt","w");
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