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
				$sql="INSERT INTO `tourplace`.`order`(`Order_ID`,`Ticket_ID`,`User_ID1`,`User_ID12`,
				`Order_Time`,`Order_Count`,`Order_State`)
				VALUES('$ID','$ticketid','$userid1','$userid2','$ordertime','$ordercount','1')";
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
	}else if(empty($request_data['Order_State'])){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.The Order State is empty!")));
	}else{
		$orderid=$request_data['Order_ID'];
		$orderstate=$request_data['Order_State'];
		$sql="UPDATE `tourplace`.`order` SET `Order_State`='$orderstate' 
		WHERE `Order_ID`='$orderid'";
		mysql_query($sql);
		echo json_encode(array('Type'=>0,'Result'=>""));
	}
}

/*查*/
function IFGET($request_data){
	$Key=explode('+',$request_data['Keys']);
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
		join `tourplace`.`user2` ON `order`.`User_ID2`=`user2`.`User_ID`";
	if($request_data['Type']==0){
		if(!empty($request_data['Search']['Order_ID'])){
			$orderid=$request_data['Search']['Order_ID'];
			$sql.=" WHERE `tourplace`.`order`.`Order_ID`='$orderid'";
		}
		nextstep($request_data,$sql);
	}else if($request_data['Type']==1){
		if(empty($request_data['Search']['User_ID'])){
			$userid=$request_data['Search']['User_ID'];
			$sql.=" WHERE `tourplace`.`order`.`User_ID1`='$userid'";
		}else{
			$userid=$_SESSION['User_ID'];
			$sql.=" WHERE `tourplace`.`order`.`User_ID1`='$userid'";
		}
		nextstep($request_data,$sql);
	}else if($request_data['Type']==2){
		if(empty($request_data['Search']['Order_State'])){
			$userid=$_SESSION['User_ID'];
			$sql.=" WHERE `tourplace`.`order`.`User_ID1`='$userid'";
		}else{
			$orderstate=$request_data['Search']['Order_State'];
			$sql.=" WHERE `tourplace`.`order`.`User_ID1`='$userid'";
			$sql.=" AND `tourplace`.`order`.`Order_State`=$orderstate'";
		}
		nextstep($request_data,$sql);
	}else{
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The request is error!")));
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