<?php
	include("conn.php");
	include("request.php");
	session_start();
	
	switch ($request_method) {
		case 'POST':
			IFPOST($request_data);
			break;
		case 'DELETE':
			IFDELETE($request_data);
			break;
		default:
			break;
	}
	
/*µÇÈë*/
function IFPOST($request_data){
	if(empty($request_data['User_ID'])){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The ID is empty!")));
	}else if(empty($request_data['User_Password'])){
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.The password is empty!")));
	}else{
		$ID=$request_data['User_ID'];
		$PW=$request_data['User_Password'];
		$sql="SELECT * FROM `tourplace`.`user` WHERE `User_ID`='$ID'";
		$rs=mysql_fetch_array(mysql_query($sql));
		$count=count($rs['User_ID']);
		if($count==0){
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"3.Can not find the ID!")));
		}else{
			if($rs['User_Password']==$PW){
				echo json_encode(array('Type'=>0,'Result'=>""));
				$_SESSION['User_ID']=$ID;
				$_SESSION['User_Name']=$rs['User_Name'];
				$_SESSION['User_Password']=$rs['User_Password'];
				$_SESSION['User_Truename']=$rs['User_Truename'];
				$_SESSION['User_Intro']=$rs['User_Intro'];
				$_SESSION['User_Sex']=$rs['User_Sex'];
				$_SESSION['User_Phone']=$rs['User_Phone'];
				$_SESSION['User_Birthday']=$rs['User_Birthday'];
				$_SESSION['User_IDcard']=$rs['User_IDcard'];
				$_SESSION['User_Level']=$rs['User_Level'];
				$_SESSION['Scenic_ID1']=$rs['Scenic_ID1'];
				$_SESSION['User_Type']=$rs['User_Type'];
			}else{
				echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"4.The password is error!")));
			}
		}
	}
}

/*µÇ³ö*/
function IFDELETE($request_data){
	$type=$request_data['Type'];
	if($type==0){
		$_SESSION=NULL;
		echo json_encode(array('Type'=>0,'Result'=>""));
	}else if($type==1){
		$ID=$request_data['User_ID'];
		$_SESSION=NULL;
		echo json_encode(array('Type'=>0,'Result'=>""));
	}else{
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The request is error!")));
	}
}
?>