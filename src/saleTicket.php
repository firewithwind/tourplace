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
		default:
			break;
	}
	
/*增*/
function IFPOST($request_data){
	if(empty($request_data['Type'])){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The request is error!")));
	}else{
		if($request_data['Type']==0){
			$userid=$_SESSION['User_ID'];
			$ticketid=$request_data['Data']['Ticket_ID'];
			$saleid=$request_data['Data']['User_ID'];
			$tickettype=$request_data['Data']['Ticket_Type'];
			$ticketcount=$request_data['Data']['UserTicket_Count'];
			$ticketprice=$request_data['Data']['UserTicket_Price'];
			$sql="SELECT `UserTicket_Count` FROM `tourplace`.`user-ticket` 
				WHERE `User_ID`='$saleid' AND `Ticket_ID`='$ticketid' AND `UserTicket_Type`=1";
			$rs=mysql_fetch_array(mysql_query($sql));
			$count=count($rs);
			if($count==0){
				echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"3.Can not find the goods!")));
			}else{
				if($rs['UserTicket_Count']<$ticketcount){
					echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"4.Don't have enough goods!")));
				}else if($rs['UserTicket_Count']>$ticketcount){
					$cha=$rs['UserTicket_Count']-$ticketcount;
					$sql="UPDATE `tourplace`.`user-ticket` SET `UserTicket_Count`='$cha' 
						WHERE `User_ID`='$saleid' AND `Ticket_ID`='$ticketid' AND `UserTicket_Type`=1";
					mysql_query($sql);
				}else{/*刚好售完*/
					$sql="DELETE FROM `tourplace`.`user-ticket` 
						WHERE `User_ID`='$saleid' AND `Ticket_ID`='$ticketid' AND `UserTicket_Type`=1";
					mysql_query($sql);
				}
				$sql="INSERT INTO `tourplace`.`user-ticket`(`User_ID`,`UserTicket_Price`,
				`UserTicket_Count`,`Ticket_ID`,`UserTicket_Type`)
				VALUES('$userid','$ticketprice','$ticketcount','$ticketid','$tickettype')";
				mysql_query($sql);
				echo json_encode(array('Type'=>0,'Result'=>""));
			}
		}else if($request_data['Type']==1){
			$userid=$_SESSION['User_ID'];
			$ticketid=$request_data['Data']['Ticket_ID'];
			$tickettype=$request_data['Data']['Ticket_Type'];
			$ticketcount=$request_data['Data']['UserTicket_Count'];
			$ticketprice=$request_data['Data']['UserTicket_Price'];
			$sql="SELECT `UserTicket_Count`,`UserTicket_Price` FROM `tourplace`.`user-ticket` 
				WHERE `User_ID`='$userid' AND `Ticket_ID`='$ticketid' AND `UserTicket_Type`=1";
			$rs=mysql_fetch_array(mysql_query($sql));
			$count=count($rs);
			if($count==0 || $rs['UserTicket_Price']!=$ticketprice){
				$sql="INSERT INTO `tourplace`.`user-ticket`
				(`User_ID`,`UserTicket_Price`,`UserTicket_Count`,`Ticket_ID`,`UserTicket_Type`) 
				VALUES('$userid','$ticketprice','$ticketcount','$ticketid','$tickettype')";
				mysql_query($sql);
				echo json_encode(array('Type'=>0,'Result'=>""));
			}else{
				$he=$rs['UserTicket_Count']+$ticketcount;
				$sql="UPDATE `tourplace`.`user-ticket` SET `UserTicket_Count`='$he' 
				WHERE `User_ID`='$userid' AND `Ticket_ID`='$ticketid' AND `UserTicket_Type`=1";
				mysql_query($sql);
				echo json_encode(array('Type'=>0,'Result'=>""));
			}
		}else{
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.The request is error!")));
		}
	}
}

/*改*/
function IFPUT($request_data){
	if($request_data['Type']==0){
		$userid=$_SESSION['User_ID'];
		$ticketid=$request_data['Data']['Ticket_ID'];
		$tickettype=$request_data['Data']['UserTicket_Type'];
		$targettype=$request_data['Data']['Target_Type'];
		$ticketcount=$request_data['Data']['UserTicket_Count'];
		$ticketprice=$request_data['Data']['UserTicket_Price'];
		$sql="SELECT * FROM `tourplace`.`user-ticket` 
			WHERE `User_ID`='$userid' AND `Ticket_ID`='$ticketid' AND `UserTicket_Type`='$tickettype'";
		$rs=mysql_fetch_array(mysql_query($sql));
		$count=count($rs);
		if($count==0){
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.Can not find the goods!")));
		}else if($tickettype==$targettype && $ticketprice==$rs['UserTicket_Price']){
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"3.Don't have to update!")));
		}else if($rs['UserTicket_Count']<$ticketcount){
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"3.Do not have enough goods!")));
		}else{
			if($rs['UserTicket_Count']==$ticketcount){
				$sql="UPDATE `tourplace`.`user-ticket` SET 
					`User_ID`='$userid',
					`UserTicket_Price`='$ticketprice',
					`UserTicket_Count`='$ticketcount',
					`Ticket_ID`='$ticketid',
					`UserTicket_Type`='$targettype'
				WHERE `User_ID`='$userid' AND `Ticket_ID`='$ticketid' AND `UserTicket_Type`='$tickettype'";
			}else{
				$cha=$rs['UserTicket_Count']-$ticketcount;
				$sql="UPDATE `tourplace`.`user-ticket` SET `UserTicket_Count`='$cha' 
				WHERE `User_ID`='$userid' AND `Ticket_ID`='$ticketid' AND `UserTicket_Type`='$tickettype'";
				mysql_query($sql);
				$sql="INSERT INTO `tourplace`.`user-ticket`
				(`User_ID`,`UserTicket_Price`,`UserTicket_Count`,`Ticket_ID`,`UserTicket_Type`) 
				VALUES('$userid','$ticketprice','$ticketcount','$ticketid','$targettype')";
			}
			mysql_query($sql);
			echo json_encode(array('Type'=>0,'Result'=>""));
		}
	}else{
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The request is error!")));
	}
}

/*查*/
function IFGET($request_data){
	$userid=$_SESSION['User_ID'];
	$page=$request_data['Page'];
	$pagesize=$request_data['PageSize'];
	$sql="SELECT `tourplace`.`ticket`.`Ticket_ID`,
		`tourplace`.`ticket`.`Ticket_Picture`,
		`tourplace`.`user-ticket`.`UserTicket_Type`,
		`tourplace`.`user-ticket`.`UserTicket_Price`,
		`tourplace`.`user-ticket`.`UserTicket_Count`,
		`tourplace`.`user`.`User_ID`,
		`tourplace`.`user`.`User_Name`,
		`tourplace`.`scenic`.`Scenic_ID`,
		`tourplace`.`scenic`.`Scenic_Name` 
		FROM `tourplace`.`user`,`tourplace`.`ticket`,`tourplace`.`user-ticket`,`tourplace`.`scenic` 
		WHERE `tourplace`.`user`.`User_ID`=`tourplace`.`user-ticket`.`User_ID` AND 
		`tourplace`.`ticket`.`Ticket_ID`=`tourplace`.`user-ticket`.`Ticket_ID` AND 
		`tourplace`.`scenic`.`Scenic_ID`=`tourplace`.`ticket`.`Scenic_ID`";
	if($request_data['Type']==0){
		if(empty($request_data['Search']['Ticket_ID'])){
			$sql.=" AND `tourplace`.`user`.`User_ID`='$userid'";
		}else if(empty($request_data['Search']['Ticket_Type'])){
			$ticketid=$request_data['Search']['Ticket_ID'];
			$sql.=" AND `tourplace`.`user`.`User_ID`='$userid'";
			$sql.=" AND `tourplace`.`ticket`.`Ticket_ID`='$ticketid'";
		}else{
			$ticketid=$request_data['Search']['Ticket_ID'];
			$tickettype=$request_data['Search']['Ticket_Type'];
			$sql.=" AND `tourplace`.`user`.`User_ID`='$userid'";
			$sql.=" AND `tourplace`.`ticket`.`Ticket_ID`='$ticketid'";
			$sql.=" AND `tourplace`.`user-ticket`.`Ticket_Type`='$tickettype'";
		}
		$rs=mysql_fetch_array(mysql_query($sql));
	}else if($request_data['Type']==1){
		if(empty($request_data['Search']['User_ID'])){
		}else if(empty($request_data['Search']['Ticket_ID'])){
			$Suserid=$request_data['Search']['User_ID'];
			$sql.=" AND `tourplace`.`user`.`User_ID`='$Suserid'";
		}else if(empty($request_data['Search']['Scenic_ID'])){
			$ticketid=$request_data['Search']['Ticket_ID'];
			$Suserid=$request_data['Search']['User_ID'];
			$sql.=" AND `tourplace`.`user`.`User_ID`='$Suserid'";
			$sql.=" AND `tourplace`.`ticket`.`Ticket_ID`='$ticketid'";
		}else if(empty($request_data['Search']['Ticket_Type']){
			$ticketid=$request_data['Search']['Ticket_ID'];
			$Suserid=$request_data['Search']['User_ID'];
			$scenicid=$request_data['Search']['Scenic_ID'];
			$sql.=" AND `tourplace`.`user`.`User_ID`='$Suserid'";
			$sql.=" AND `tourplace`.`ticket`.`Ticket_ID`='$ticketid'";
			$sql.=" AND `tourplace`.`ticket`.`Scenic_ID`='$scenicid'";
		}else{
			$ticketid=$request_data['Search']['Ticket_ID'];
			$Suserid=$request_data['Search']['User_ID'];
			$scenicid=$request_data['Search']['Scenic_ID'];
			$tickettype=$request_data['Search']['Ticket_Type'];
			$sql.=" AND `tourplace`.`user`.`User_ID`='$Suserid'";
			$sql.=" AND `tourplace`.`ticket`.`Ticket_ID`='$ticketid'";
			$sql.=" AND `tourplace`.`ticket`.`Scenic_ID`='$scenicid'";
			$sql.=" AND `tourplace`.`user-ticket`.`Ticket_Type`='$tickettype'";
		}
		$rs=mysql_fetch_array(mysql_query($sql));
	}else{
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The request is error!")));
	}
	
}
?>