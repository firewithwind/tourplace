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
		case 'PUT':
			IFPUT($request_data);
			break;
		default:
			break;
	}
	
/*注册*/
function IFPOST($request_data){
	if(empty($request_data['Data']['User_name'])){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The name is empty!")));
	}else if(empty($request_data['Data']['User_Password'])){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.The password is empty!")));
	}else{
		if($request_data['Type']==0){/*普通用户*/
			$name=$request_data['Data']['User_name'];
			$password=$request_data['Data']['User_Password'];
			$intro=$request_data['Data']['User_Intro'];
			$type=$request_data['Data']['User_Type'];
			$ID=getID($type);
			if($ID=='99999999'){/*失败*/
				echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"6.The ID is fulled!")));
			}else{/*成功*/
				$sql="INSERT INTO `tourplace`.`user`(`User_ID`,`User_Name`,`User_Password`,
				`User_Truename`,`User_Intro`,`User_Sex`,`User_Phone`,`User_Birthday`,`User_IDcard`,
				`User_Level`,`Scenic_ID1`,`User_Type`,`User_Picture`)
				VALUES('$ID','$name','$password',NULL,'$intro',NULL,NULL,NULL,NULL,'50',NULL,'$type','/tourplace/img/user/00.jpg')";
				mysql_query($sql);
				$sql="INSERT INTO `tourplace`.`user2`(`User_ID`,`User_Name`,`User_Password`,
				`User_Truename`,`User_Intro`,`User_Sex`,`User_Phone`,`User_Birthday`,`User_IDcard`,
				`User_Level`,`Scenic_ID1`,`User_Type`,`User_Picture`)
				VALUES('$ID','$name','$password',NULL,'$intro',NULL,NULL,NULL,NULL,'50',NULL,'$type','/tourplace/img/user/00.jpg')";
				mysql_query($sql);
				echo json_encode(array('Type'=>0,'Result'=>array('User_ID'=>$ID)));
			}
		}else if($request_data['Type']==1){/*官方用户*/
			if(empty($request_data['Data']['Sight'])){
				echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"4.The scenic is empty!")));
			}else if(empty($request_data['Data']['Liscen'])){
				echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"5.The license is empty!")));
			}else{
				$name=$request_data['Data']['User_name'];
				$password=$request_data['Data']['User_Password'];
				$intro=$request_data['Data']['User_Intro'];
				$type=$request_data['Data']['User_Type'];
				$Sname=$request_data['Data']['Sight'];
				$Slicense=$request_data['Data']['Liscen'];
				$sql="select * from scenic where `Scenic_Name`='$Sname' and `Scenic_License`='$Slicense'";
				$query=mysql_query($sql);
				$rs=mysql_fetch_array($query);
				$count=count($rs['Scenic_ID']);
				if($count==0){
					echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"7.The scenic data is error!")));
				}else{
					$ID=getID($type);
					if($ID=='99999999'){/*失败*/
						echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"6.The ID is fulled!")));
					}else{/*成功*/
						$scenicid=$rs['Scenic_ID'];
						$sql="INSERT INTO `tourplace`.`user`(`User_ID`,`User_Name`,`User_Password`,
						`User_Truename`,`User_Intro`,`User_Sex`,`User_Phone`,`User_Birthday`,`User_IDcard`,
						`User_Level`,`Scenic_ID1`,`User_Type`,`User_Picture`)
						VALUES('$ID','$name','$password',NULL,'$intro',NULL,NULL,NULL,NULL,'50','$scenicid','$type','/tourplace/img/user/00.jpg')";
						mysql_query($sql);
						$sql="INSERT INTO `tourplace`.`user2`(`User_ID`,`User_Name`,`User_Password`,
						`User_Truename`,`User_Intro`,`User_Sex`,`User_Phone`,`User_Birthday`,`User_IDcard`,
						`User_Level`,`Scenic_ID1`,`User_Type`,`User_Picture`)
						VALUES('$ID','$name','$password',NULL,'$intro',NULL,NULL,NULL,NULL,'50','$scenicid','$type','/tourplace/img/user/00.jpg')";
						mysql_query($sql);
						echo json_encode(array('Type'=>0,'Result'=>array('User_ID'=>$ID)));
					}
				}
			}
		}
	}
}

/*删除*/
function IFDELETE($request_data){
	if(empty($request_data['User_ID'])){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The ID is empty!")));
	}else{
		$dID=$request_data['User_ID'];
		$sql="SELECT * FROM `tourplace`.`user` WHERE `User_ID`='$dID'";
		$rs=mysql_fetch_array(mysql_query($sql));
		$count=count($rs);
		if($count==0){
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.Can not find the ID!")));
		}else{
			$sql="DELETE FROM `tourplace`.`user` WHERE `user`.`User_ID`='$dID'";
			mysql_query($sql);
			$sql="DELETE FROM `tourplace`.`user2` WHERE `user2`.`User_ID`='$dID'";
			mysql_query($sql);
			echo json_encode(array('Type'=>0,'Result'=>array('User_ID'=>$dID)));
		}
	}
}

/*修改*/
function IFPUT($request_data){
	if($request_data['Type']==1 && empty($request_data['User_ID'])){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.Can not find the ID!")));
	}else{
		if(!isset($request_data['Update']['User_Name'])||
			 !isset($request_data['Update']['User_Password'])||
			 !isset($request_data['Update']['User_Truename'])||
			 !isset($request_data['Update']['User_Intro'])||
			 !isset($request_data['Update']['User_Sex'])||
			 !isset($request_data['Update']['User_Phone'])||
			 !isset($request_data['Update']['User_Birthday'])||
			 !isset($request_data['Update']['User_IDcard'])||
			 !isset($request_data['Update']['User_Level'])||
			 !isset($request_data['Update']['User_Picture'])){
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.The data is not complete!")));
		}else{
			if($request_data['Type']==0){
				$gID=$_SESSION['User_ID'];
			}else if($request_data['Type']==1){
				$gID=$request_data['User_ID'];
			}else{
				echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"3.The operation number is error!")));
			}
			$sql="SELECT * FROM `tourplace`.`user` WHERE `User_ID`='$gID'";
			$rs=mysql_fetch_array(mysql_query($sql));
			$count=count($rs);
			if($count==0){
				echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"4.Can not find the ID!")));
			}else{
				$aa1=$request_data['Update']['User_Name'];
				$aa2=$request_data['Update']['User_Password'];
				$aa3=$request_data['Update']['User_Truename'];
				$aa4=$request_data['Update']['User_Intro'];
				$aa5=$request_data['Update']['User_Sex'];
				$aa6=$request_data['Update']['User_Phone'];
				$aa7=$request_data['Update']['User_Birthday'];
				$aa8=$request_data['Update']['User_IDcard'];
				$aa9=$request_data['Update']['User_Level'];
				$aa10=$request_data['Update']['User_Picture'];
				$sql="UPDATE `tourplace`.`user` SET 
					`User_Name`='$aa1',
					`User_Password`='$aa2',
					`User_Truename`='$aa3',
					`User_Intro`='$aa4',
					`User_Sex`='$aa5',
					`User_Phone`='$aa6',
					`User_Birthday`='$aa7',
					`User_IDcard`='$aa8',
					`User_Level`='$aa9' 
					`User_Picture`='$aa10' 
					WHERE `User_ID`='$gID'";
				mysql_query($sql);
				$sql="UPDATE `tourplace`.`user2` SET 
					`User_Name`='$aa1',
					`User_Password`='$aa2',
					`User_Truename`='$aa3',
					`User_Intro`='$aa4',
					`User_Sex`='$aa5',
					`User_Phone`='$aa6',
					`User_Birthday`='$aa7',
					`User_IDcard`='$aa8',
					`User_Level`='$aa9' 
					`User_Picture`='$aa10' 
					WHERE `User_ID`='$gID'";
				mysql_query($sql);
				echo json_encode(array('Type'=>0,'Result'=>array('User_ID'=>$gID)));
			}
		}
	}
}

/*查询*/
function IFGET($request_data){
	if(!isset($request_data['Type'])){
		echo json_encode(array('Type'=>1,'Num'=>0,'Result'=>array('Errmsg'=>"1.The request is error!")));
	}else{
		$searchtype=$request_data['Type'];
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
		if($searchtype==0){
			$id="";
			if(empty($request_data['Search']['User_ID'])) $id=$_SESSION['User_ID'];
			else $id=$request_data['Search']['User_ID'];
			$sql.=" FROM `tourplace`.`user` WHERE `User_ID`='$id'";
			nextstep($request_data,$sql);
		}else if($searchtype==1){
			if(empty($request_data['Search']['User_Name'])){
				echo json_encode(array('Type'=>1,'Num'=>0,'Result'=>array('Errmsg'=>"2.The user name is empty!")));
			}else{
				$name=$request_data['Search']['User_Name'];
				$sql.=" FROM `tourplace`.`user` WHERE `User_Name`='$name'";
			}
			nextstep($request_data,$sql);
		}else if($searchtype==2){
			if(empty($request_data['Search']['User_IDcard'])){
				echo json_encode(array('Type'=>1,'Num'=>0,'Result'=>array('Errmsg'=>"3.The user card is empty!")));
			}else{
				$card=$request_data['Search']['User_IDcard'];
				$sql.=" FROM `tourplace`.`user` WHERE `User_IDcard`='$card'";
			}
			nextstep($request_data,$sql);
		}else if($searchtype==3){
			$type=$request_data['Search']['Type'];
			if($type==0){
				$sql.=" FROM `tourplace`.`user` WHERE `User_Type`='0'";
			}else if($type==1){
				$sql.=" FROM `tourplace`.`user` WHERE `User_Type`='1'";
			}else{
				$sql.=" FROM `tourplace`.`user`";
			}
			nextstep($request_data,$sql);
		}
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
	
function getID($usertype){
	if($usertype=='0'){
		if(!@$f=fopen("ID_Record\User_ID_0.txt","r")){
			$ID_0=1;
			$ff=fopen("ID_Record\User_ID_0.txt","w");
			fwrite($ff,$ID_0);
			fclose($ff);
		}else{
			$ID_0=fgets($f,10);
			fclose($f);
			$ID_0++;
			$ff=fopen("ID_Record\User_ID_0.txt","w");
			fwrite($ff,$ID_0);
			fclose($ff);
		}
		if(strlen($ID_0)>7)/*id已满*/
			return '99999999';
		else{
			$num=7-strlen($ID_0);
			while($num>0){
				$ID_0='0'.$ID_0;
				$num--;
			}
			$ID_0='0'.$ID_0;
			return $ID_0;
		}
	}else{
		if(!@$f=fopen("ID_Record\User_ID_1.txt","r")){
			$ID_1=1;
			$ff=fopen("ID_Record\User_ID_1.txt","w");
			fwrite($ff,$ID_1);
			fclose($ff);
		}else{
			$ID_1=fgets($f,10);
			fclose($f);
			$ID_1++;
			$ff=fopen("ID_Record\User_ID_1.txt","w");
			fwrite($ff,$ID_1);
			fclose($ff);
		}
		if(strlen($ID_1)>7)/*id已满*/
			return '99999999';
		else{
			$num=7-strlen($ID_1);
			while($num>0){
				$ID_1='0'.$ID_1;
				$num--;
			}
			$ID_1='1'.$ID_1;
			return $ID_1;
		}
	}
}

?>