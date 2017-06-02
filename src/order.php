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
		case 'PUT':
			IFPUT($request_data);
			break;
		case 'DELETE':
			IFDELETE($request_data);
			break;
		default:
			break;
	}
	
/*增*/
function IFPOST($request_data){
	$userid2=$request_data['User_ID2'];
	$ticketid=$request_data['Ticket_ID'];
	$sql="SELECT * FROM `tourplace`.`user` WHERE `User_ID`='$userid2'";
	$rs=mysql_fetch_array(mysql_query($sql));
	$count=count($rs);
	if($count==0){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.The user is not exist!")));
	}else if($rs['User_Type']==0){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"3.The user is not saler!")));
	}else{
		$sql="SELECT * FROM `tourplace`.`ticket` WHERE `Ticket_ID`='$ticketid'";
		$rs=mysql_fetch_array(mysql_query($sql));
		$count=count($rs);
		if($count==0){
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"4.The ticket is not exist!")));
		}else{
			$ID=getID();
			if($ID=='99999999'){
				echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"5.The order ID is fulled!")));
			}else{
				$userid1=$_SESSION['User_ID'];
				$ordertime=$request_data['Order_Time'];
				$ordercount=$request_data['Order_Count'];
				$orderprice=$request_data['Order_Price'];
				$zprice=$ordercount*$orderprice;
				$sql="INSERT INTO `tourplace`.`order`(`Order_ID`,`Ticket_ID`,`User_ID1`,`User_ID2`,
				`Order_Time`,`Order_Count`,`Order_State`,`Order_Price`)
				VALUES('$ID','$ticketid','$userid1','$userid2','$ordertime','$ordercount','0','$zprice')";
				mysql_query($sql);
				echo json_encode(array('Type'=>0,'Result'=>array('Order_ID'=>$ID)));
			}
		}
	}
}

/*删*/
function IFDELETE($request_data){
	if(empty($request_data['Order_ID'])){
		$userid1=$_SESSION['User_ID'];
		$sql="DELETE FROM `tourplace`.`order` WHERE `order`.`User_ID1`='$userid1'";
		mysql_query($sql);
		echo json_encode(array('Type'=>0,'Result'=>""));
	}else{
		$orderid=$request_data['Order_ID'];
		$sql="SELECT * FROM `tourplace`.`order` WHERE `Order_ID`='$orderid'";
		$rs=mysql_fetch_array(mysql_query($sql));
		$count=count($rs);
		if($count==0){
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.Can not find the order ID!")));
		}else{
			$sql="DELETE FROM `tourplace`.`order` WHERE `order`.`Order_ID`='$orderid'";
			mysql_query($sql);
			echo json_encode(array('Type'=>0,'Result'=>""));
		}
	}
}

/*改*/
function IFPUT($request_data){
	if(empty($request_data['Order_ID'])){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The Order ID is empty!")));
	}else if(!isset($request_data['Order_State'])){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.The Order State is empty!")));
	}else{
		$orderid=$request_data['Order_ID'];
		$orderstate=$request_data['Order_State'];
		$sql="UPDATE `tourplace`.`order` SET `Order_State`='$orderstate' 
		WHERE `Order_ID`='$orderid'";
		mysql_query($sql);
		Sale($orderid);
	}
}

function Sale($orderid){
	$sql="SELECT * FROM `tourplace`.`order` 
		WHERE `Order_ID`='$orderid'";
	$rs=mysql_fetch_array(mysql_query($sql));
	$count=count($rs['Order_ID']);
	if($count==0){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"3.Can not find the order!")));
	}else{
		$buyer=$rs['User_ID1'];
		$saler=$rs['User_ID2'];
		$ticketid=$rs['Ticket_ID'];
		$ticketcount=$rs['Order_Count'];
		$sql="SELECT `UserTicket_Count` FROM `tourplace`.`user-ticket` 
			WHERE `User_ID`='$saler' AND `Ticket_ID`='$ticketid' AND `UserTicket_Type`=1";
		$rs=mysql_fetch_array(mysql_query($sql));
		$count=count($rs['UserTicket_Count']);
		if($count==0){
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"4.Can not find the goods!")));
		}else{
			if($rs['UserTicket_Count']<$ticketcount){
				echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"5.Don't have enough goods!")));
				return;
			}else if($rs['UserTicket_Count']>$ticketcount){
				$cha=$rs['UserTicket_Count']-$ticketcount;
				$sql="UPDATE `tourplace`.`user-ticket` SET `UserTicket_Count`='$cha' 
					WHERE `User_ID`='$saler' AND `Ticket_ID`='$ticketid' AND `UserTicket_Type`=1";
				mysql_query($sql);
			}else{/*刚好售完*/
				$sql="DELETE FROM `tourplace`.`user-ticket` 
					WHERE `User_ID`='$saler' AND `Ticket_ID`='$ticketid' AND `UserTicket_Type`=1";
				mysql_query($sql);
			}
			$sql="SELECT `UserTicket_Count` FROM `tourplace`.`user-ticket` 
				WHERE `User_ID`='$buyer' AND `Ticket_ID`='$ticketid' AND `UserTicket_Type`=0";
			$rs=mysql_fetch_array(mysql_query($sql));
			$count=count($rs['UserTicket_Count']);
			if($count==0){
				$sql="INSERT INTO `tourplace`.`user-ticket`(`User_ID`,`UserTicket_Price`,
					`UserTicket_Count`,`Ticket_ID`,`UserTicket_Type`)
					VALUES('$buyer','0','$ticketcount','$ticketid','0')";
				mysql_query($sql);
			}else{
				$he=$rs['UserTicket_Count']+$ticketcount;
				$sql="UPDATE `tourplace`.`user-ticket` SET `UserTicket_Count`='$he' 
					WHERE `User_ID`='$buyer' AND `Ticket_ID`='$ticketid' AND `UserTicket_Type`=0";
				mysql_query($sql);
			}
			echo json_encode(array('Type'=>0,'Result'=>""));
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
			if($Key[$i]=="User_Name1")
				$sql.="`user`.`User_Name`";
			else if($Key[$i]=="User_Name2")
				$sql.="`user2`.`User_Name`";
			else{
				if($Key[$i]=="Ticket_ID")
					$sql.="`order`.";
				if($Key[$i]=="Scenic_ID")
					$sql.="`scenic`.";
				$sql.="`".$Key[$i]."`";
			}
			if($i!=$arrcount-1) $sql.=",";
			$i++;
		}
	}
	$sql.=" FROM `tourplace`.`user` join `tourplace`.`order` ON `user`.`User_ID`=`order`.`User_ID1` 
		join `tourplace`.`ticket` ON `order`.`Ticket_ID`=`ticket`.`Ticket_ID` 
		join `tourplace`.`scenic` ON `ticket`.`Scenic_ID`=`scenic`.`Scenic_ID` 
		join `tourplace`.`user2` ON `order`.`User_ID2`=`user2`.`User_ID` WHERE 1";
	if($request_data['Type']==0){
		if(!empty($request_data['Search']['Order_ID'])){
			$orderid=$request_data['Search']['Order_ID'];
			$sql.=" AND `tourplace`.`order`.`Order_ID`='$orderid'";
		}
		nextstep($request_data,$sql);
	}else if($request_data['Type']==1){
		if(empty($request_data['Search']['User_ID'])){
			$userid=$request_data['Search']['User_ID'];
			$sql.=" AND `tourplace`.`order`.`User_ID1`='$userid'";
		}else{
			$userid=$_SESSION['User_ID'];
			$sql.=" AND `tourplace`.`order`.`User_ID1`='$userid'";
		}
		nextstep($request_data,$sql);
	}else if($request_data['Type']==2){
		$userid=$_SESSION['User_ID'];
		$sql.=" AND `tourplace`.`order`.`User_ID1`='$userid'";
		if(isset($request_data['Search']['Order_State'])){
			$orderstate=$request_data['Search']['Order_State'];
			$sql.=" AND `tourplace`.`order`.`Order_State`='$orderstate'";
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
	if(!@$f=fopen("ID_Record\Order_ID.txt","r")){
		$ID_0=1;
		$ff=fopen("ID_Record\Order_ID.txt","w");
		fwrite($ff,$ID_0);
		fclose($ff);
	}else{
		$ID_0=fgets($f,10);
		fclose($f);
		$ID_0++;
		$ff=fopen("ID_Record\Order_ID.txt","w");
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