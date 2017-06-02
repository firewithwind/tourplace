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
	
/*Ôö*/
function IFPOST($request_data){
	if($request_data['Type']==0){
		$ScenicID=$request_data['Data']['Scenic_ID'];
		$sql="SELECT * FROM `tourplace`.`scenic` WHERE `Scenic_ID`='$ScenicID'";
		$rs=mysql_fetch_array(mysql_query($sql));
		$count=count($rs);
		if($count==0){
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.Can not find the scenic ID!")));
		}else{
			$ID=getID();
			if($ID=='99999999'){
				echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"3.The ticket ID is fulled!")));
			}else{
				$Time=$request_data['Data']['Ticket_Time'];
				$Pic="/tourplace/img/user/11.png";
				$sql="INSERT INTO `tourplace`.`ticket`(`Ticket_ID`,`Scenic_ID`,`Ticket_Picture`,`Ticket_Time`)
				VALUES('$ID','$ScenicID','$Pic','$Time')";
				mysql_query($sql);
				echo json_encode(array('Type'=>0,'Result'=>array('Ticket_ID'=>$ID)));
			}
		}
	}else{
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The request is error!")));
	}
}

/*É¾*/
function IFDELETE($request_data){
	if(empty($request_data['Type'])){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The request is error!")));
	}else{
		if($request_data['Type']==0){
			$ID=$request_data['Data']['Ticket_ID'];
			$sql="SELECT * FROM `tourplace`.`ticket` WHERE `Ticket_ID`='$ID'";
			$rs=mysql_fetch_array(mysql_query($sql));
			$count=count($rs);
			if($count==0){
				echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.Can not find the ticket ID!")));
			}else{
				$sql="DELETE FROM `tourplace`.`ticket` WHERE `ticket`.`Ticket_ID`='$ID'";
				mysql_query($sql);
				echo json_encode(array('Type'=>0,'Result'=>""));
			}
		}else{
			$Scenic=$request_data['Data']['Scenic_ID'];
			if(empty($request_data['Data']['Ticket_Time'])){
				$sql="SELECT * FROM `tourplace`.`ticket` WHERE `Scenic_ID`='$Scenic'";
				$rs=mysql_fetch_array(mysql_query($sql));
				$count=count($rs);
				if($count==0){
					echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"3.Can not find the scenic ID!")));
				}else{
					$sql="DELETE FROM `tourplace`.`ticket` WHERE `ticket`.`Scenic_ID`='$Scenic'";
					mysql_query($sql);
					echo json_encode(array('Type'=>0,'Result'=>""));
				}
			}else{
				$Time=$request_data['Data']['Ticket_Time'];
				$sql="SELECT * FROM `tourplace`.`ticket` WHERE `Scenic_ID`='$Scenic'";
				$rs=mysql_fetch_array(mysql_query($sql));
				$count=count($rs);
				if($count==0){
					echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"4.Can not find the scenic and time!")));
				}else{
					$sql="DELETE FROM `tourplace`.`ticket` WHERE `ticket`.`Scenic_ID`='$Scenic' AND `ticket`.`Ticket_Time`='$Time'";
					mysql_query($sql);
					echo json_encode(array('Type'=>0,'Result'=>""));
				}
			}
		}
	}
}

/*²é*/
function IFGET($request_data){
	if(empty($request_data['Type'])){
		echo json_encode(array('Type'=>1,'Num'=>0,'Result'=>array('Errmsg'=>"1.The request is error!")));
	}else{
		$page=$request_data['Page'];
		$pagesize=$request_data['PageSize'];
		$searchtype=$request_data['Type'];
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
		$result=array();
		if($searchtype==0){
			if(empty($request_data['Search']['Ticket_ID'])){
				$sql.=" FROM `tourplace`.`ticket` WHERE 1";
			}else{
				$tid=$request_data['Search']['Ticket_ID'];
				$sql.=" FROM `tourplace`.`ticket` WHERE `Ticket_ID`='$tid'";
			}
		}else if($searchtype==1){
			if(empty($request_data['Search']['Scenic_ID'])){
				echo json_encode(array('Type'=>1,'Num'=>0,'Result'=>array('Errmsg'=>"0.The Scenic_ID is empty!")));
			}else{
				$sid=$request_data['Search']['Scenic_ID'];
				if(empty($request_data['Search']['Ticket_Time'])){
					$sql.=" FROM `tourplace`.`ticket` WHERE `Scenic_ID`='$sid'";
				}else{
					$time=$request_data['Search']['Ticket_Time'];
					$sql.=" FROM `tourplace`.`ticket` WHERE `Scenic_ID`='$sid' AND `Ticket_Time`='$time'";
				}
			}
		}else if($searchtype==2){
			$name=$request_data['Search']['Scenic_Name'];
			$sql1="SELECT Scenic_ID FROM `tourplace`.`scenic` WHERE `Scenic_Name`='$name'";
			if(empty($request_data['Search']['Ticket_Time'])){
				$sql.=" FROM `tourplace`.`ticket` WHERE `Scenic_ID`=(".$sql1.")";
			}else{
				$time=$request_data['Search']['Ticket_Time'];
				$sql.=" FROM `tourplace`.`ticket` WHERE `Ticket_Time`='$time' AND `Scenic_ID` IN(".$sql1.")";
			}
		}else if($searchtype==3){
			if(empty($request_data['Search']['Province_ID'])){
				$sql.=" FROM `tourplace`.`ticket` WHERE 1";
			}else if(empty($request_data['Search']['City_ID'])){
				$pro=$request_data['Search']['Province_ID'];
				$sql3="SELECT Province_ID FROM `tourplace`.`province` WHERE `Province_ID`='$pro'";
				$sql2="SELECT City_ID FROM `tourplace`.`city` WHERE `Province_ID` IN(".$sql3.")";
				$sql1="SELECT Scenic_ID FROM `tourplace`.`scenic` WHERE `City_ID` IN(".$sql2.")";
				$sql.=" FROM `tourplace`.`ticket` WHERE `Scenic_ID` IN(".$sql1.")";
			}else{
				$pro=$request_data['Search']['Province_ID'];
				$city=$request_data['Search']['City_ID'];
				$sqlx="SELECT * FROM `tourplace`.`city` WHERE `Province_ID`='$pro' AND `City_ID`='$city'";
				$rs=mysql_fetch_array(mysql_query($sqlx));
				$count=count($rs);
				if($count==0){
					echo json_encode(array('Type'=>1,'Num'=>0,'Result'=>array('Errmsg'=>"2.Can not find the location!")));
				}else{
					$sql1="SELECT Scenic_ID FROM `tourplace`.`scenic` WHERE `City_ID`='$city'";
					$sql.=" FROM `tourplace`.`ticket` WHERE `Scenic_ID` IN(".$sql1.")";
				}
			}
		}
		$query=mysql_query($sql);
		while($row=mysql_fetch_assoc($query))
			$result[]=$row;
		$resultcount=count($result);
		$pre=$pagesize*($page-1);
		if($pre>$resultcount){
			echo json_encode(array('Type'=>1,'Num'=>0,'Result'=>array('Errmsg'=>"1.The page number is error!")));
		}else{
			$finalresult=array();
			$finalcount=0;
			while($finalcount<$pagesize && $pre+$finalcount<$resultcount){
				$finalresult[]=$result[$pre+$finalcount];
				$finalcount++;
			}
			echo json_encode(array('Type'=>0,'Num'=>$finalcount,'Result'=>$finalresult));
		}
	}
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
	if(strlen($ID_0)>8)/*idÒÑÂú*/
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